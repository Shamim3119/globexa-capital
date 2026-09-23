<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientsCrud extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $updateMode = false;
    public $activeTab = 'clients';

    public $client_id;
    public $name;
    public $email;
    public $phone;
    public $address;
    public $inactive;
    public $photo;

    public $selectedClient = null;
    public $leftCount = 0;
    public $rightCount = 0;

    public $verification_status;
    public $verification_description = '';
    /*
    |--------------------------------------------------------------------------
    | Search / Filter
    |--------------------------------------------------------------------------
    */

    public $search = '';
    public $searchId = '';
    public $parentId = '';

    public $createdFrom = '';
    public $createdTo = '';

    /*
    |--------------------------------------------------------------------------
    | Reset pagination when search/filter changes
    |--------------------------------------------------------------------------
    */



    /*
    |--------------------------------------------------------------------------
    | Verification
    |--------------------------------------------------------------------------
    */

    public $verificationClient = null;

    public $verificationFirstName = '';
    public $verificationLastName = '';
    public $verificationDob = '';
    public $verificationAddress = '';
    public $verificationPostCode = '';
    public $verificationCity = '';
    public $verificationDocType = '';
    public $verificationDocImg = [];
    public $verificationStatus = 0;


    public function showVerification($id)
    {
        $this->verificationClient = Client::findOrFail($id);

        $this->verificationFirstName =
            $this->verificationClient->first_name;

        $this->verificationLastName =
            $this->verificationClient->last_nanme;

        $this->verificationDob =
            $this->verificationClient->date_of_birth;

        $this->verificationAddress =
            $this->verificationClient->verification_address;

        $this->verificationPostCode =
            $this->verificationClient->post_code;

        $this->verificationCity =
            $this->verificationClient->city;

        $this->verificationDocType =
            $this->verificationClient->doc_type;

        $this->verificationDocImg = $this->decodeDocImages(
            $this->verificationClient->doc_img
        );

        $this->verificationStatus =
            in_array($this->verificationClient->verification_status, [0, 1])
                ? $this->verificationClient->verification_status
                : 0;

        $this->verification_description =
            $this->verificationClient->verification_description;
    }

    /*
    |--------------------------------------------------------------------------
    | Decode doc_img (JSON array or legacy single path) into a clean array
    |--------------------------------------------------------------------------
    */

    private function decodeDocImages($raw)
    {
        if (empty($raw)) {
            return [];
        }

        $decoded = json_decode($raw, true);

        // Already a valid JSON array of paths
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // Fallback: legacy data was a single plain path string
        return [$raw];
    }

    public function updateVerificationStatus()
    {
        if (!$this->verificationClient) {
            return;
        }

        // Already verified - cannot change again
        if ($this->verificationClient->verification_status == 1) {

            $this->dispatch(
                'show-toast',
                message: 'This client is already verified.'
            );

            return;
        }

        $this->validate([
            'verificationStatus' => 'required|in:0,1',
        ]);

        $this->verificationClient->update([
            'verification_status' => $this->verificationStatus,
            'verification_description' => $this->verification_description,
        ]);

        $this->verificationClient->refresh();

        $message = $this->verificationStatus == 1
            ? 'Client Verification Successful'
            : 'Client Verification Cancelled';

        $this->dispatch(
            'show-toast',
            message: $message
        );

        $this->dispatch('close-verification-modal');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSearchId()
    {
        $this->resetPage();
    }

    public function updatedParentId()
    {
        $this->resetPage();
    }

    public function updatedCreatedFrom()
    {
        $this->resetPage();
    }

    public function updatedCreatedTo()
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Clear Filters
    |--------------------------------------------------------------------------
    */

    public function clearFilters()
    {
        $this->reset([
            'search',
            'searchId',
            'parentId',
            'createdFrom',
            'createdTo',
        ]);

        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Leg Count
    |--------------------------------------------------------------------------
    */

    private function getLegCount($parentId, $site)
    {
        $result = DB::select("
            WITH RECURSIVE tree AS (
                SELECT id
                FROM clients
                WHERE ref_id = ? AND site = ?

                UNION ALL

                SELECT c.id
                FROM clients c
                INNER JOIN tree t ON c.ref_id = t.id
            )
            SELECT COUNT(*) AS total
            FROM tree
        ", [$parentId, $site]);

        return $result[0]->total ?? 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Client Details
    |--------------------------------------------------------------------------
    */

    public function showDetails($id)
    {
        $this->selectedClient = Client::with('parent')->findOrFail($id);

        $this->leftCount = $this->getLegCount($id, 0);
        $this->rightCount = $this->getLegCount($id, 1);
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $query = Client::query()
            ->with('parent');

        /*
        |--------------------------------------------------------------------------
        | General Search
        |--------------------------------------------------------------------------
        */

        if ($this->search) {
            $search = trim($this->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Client ID
        |--------------------------------------------------------------------------
        */

        if ($this->searchId !== '') {
            $query->where('id', $this->searchId);
        }

        /*
        |--------------------------------------------------------------------------
        | Parent ID
        |--------------------------------------------------------------------------
        */

        if ($this->parentId !== '') {
            $query->where('ref_id', $this->parentId);
        }

        /*
        |--------------------------------------------------------------------------
        | Created From
        |--------------------------------------------------------------------------
        */

        if ($this->createdFrom) {
            $query->whereDate('created_at', '>=', $this->createdFrom);
        }

        /*
        |--------------------------------------------------------------------------
        | Created To
        |--------------------------------------------------------------------------
        */

        if ($this->createdTo) {
            $query->whereDate('created_at', '<=', $this->createdTo);
        }

        /*
        |--------------------------------------------------------------------------
        | Totals
        |--------------------------------------------------------------------------
        |
        | Calculate totals BEFORE pagination so totals represent
        | all records matching the current filters.
        |
        */

        $totalDeposit = (clone $query)->sum('deposit_balance');

        $totalInvestment = (clone $query)->sum('investment_balance');

        $totalIncome = (clone $query)->sum('income_balance');

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $clients = $query
            ->orderByDesc('verification_status')
            ->orderBy('id', 'asc')
            ->paginate(25);

        return view('livewire.clients.clients-crud', [
            'clients' => $clients,
            'totalDeposit' => $totalDeposit,
            'totalInvestment' => $totalInvestment,
            'totalIncome' => $totalIncome,
        ])->layout('layouts.app', [
            'title' => 'Clients',
            'sub_title' => 'Clients List'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Store / Update
    |--------------------------------------------------------------------------
    */

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email',
            'inactive' => 'required|boolean',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = null;

        if ($this->photo && is_object($this->photo)) {
            $photoPath = $this->photo->store('clients', 'public');
        }

        if ($this->client_id) {

            $client = Client::findOrFail($this->client_id);

            $data = [
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'inactive' => $this->inactive,
            ];

            if ($photoPath) {
                $data['photo'] = $photoPath;
            }

            $client->update($data);

            $message = 'Client Updated Successfully';

        } else {

            Client::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'inactive' => $this->inactive,
                'photo' => $photoPath,
            ]);

            $message = 'Client Created Successfully';
        }

        $this->dispatch(
            'show-toast',
            message: $message
        );

        $this->resetInputFields();

        $this->updateMode = false;
    }

    /*
    |--------------------------------------------------------------------------
    | Reset Form
    |--------------------------------------------------------------------------
    */

    private function resetInputFields()
    {
        $this->client_id = null;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->address = '';
        $this->inactive = false;
        $this->photo = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Cancel
    |--------------------------------------------------------------------------
    */

    public function cancel()
    {
        $this->updateMode = false;

        $this->resetInputFields();
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $client = Client::findOrFail($id);

        $this->inactive = $client->inactive;
        $this->client_id = $client->id;
        $this->name = $client->name;
        $this->email = $client->email;
        $this->phone = $client->phone;
        $this->address = $client->address;

        /*
         * Don't assign old photo path to WithFileUploads.
         */
        $this->photo = null;

        $this->updateMode = true;
    }
}