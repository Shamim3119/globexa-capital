<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use App\Models\Client;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;


class ClientsCrud extends Component
{

    use WithFileUploads;

    public $updateMode = false;
    public $activeTab = 'clients';
    public $client_id, $name, $email, $phone, $address, $inactive;
    public $photo;

    public $selectedClient = null;
    public $leftCount = 0;
    public $rightCount = 0;


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

    public function showDetails($id)
    {
        $this->selectedClient = Client::findOrFail($id);

        $this->leftCount = $this->getLegCount($id, 0);
        $this->rightCount = $this->getLegCount($id, 1);
    }
    
    
    public function render()
    {
        return view('livewire.clients.clients-crud', [
            'clients' => Client::with('parent')->get(),
        ])->layout('layouts.app', [
            'title' => 'Clients',
            'sub_title' => 'Clients List'
        ]);
    }
 
    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email',
            'inactive' => 'required|boolean',
            'photo' => 'nullable|image|max:2048', // 2MB max
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

        } else {

            Client::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'inactive' => $this->inactive,
                'photo' => $photoPath,
            ]);
        }

        $this->dispatch('show-toast',
            message: $this->client_id
                ? 'Client Updated Successfully'
                : 'Client Created Successfully'
        );

        $this->resetInputFields();
        $this->updateMode = false;
    }
 
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


    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function edit($id)
    {
 
        if ($id) {
            $client = Client::findOrFail($id);
            $this->inactive = $client->inactive;
            $this->client_id = $client->id;
            $this->name = $client->name;
            $this->email = $client->email;
            $this->phone = $client->phone;
            $this->address = $client->address;
            $this->photo = $client->photo;

            $this->updateMode = true;
          //  $this->dispatch('open-edit-box');
        }
    }
}
