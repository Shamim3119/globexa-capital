<?php

namespace App\Livewire\Withdraw;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use App\Models\Withdraw;
use App\Models\Client;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

use App\Mail\WithdrawStatusMail;

class WithdrawCrud extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $updateMode = false;
    public $activeTab = 'withdraw';

    /*
    |--------------------------------------------------------------------------
    | Selected Withdraw
    |--------------------------------------------------------------------------
    */

    public $selectedwithdrawId;
    public $selectedStatus;
    public $selectedwithdraw;

    public $trxid;
    public $withdraw_doc;

    /*
    |--------------------------------------------------------------------------
    | Search / Filters
    |--------------------------------------------------------------------------
    */

    public $search = '';
    public $withdrawId = '';
    public $clientId = '';

    public $createdFrom = '';
    public $createdTo = '';

    public $sendFrom = '';
    public $sendTo = '';

    /*
    |--------------------------------------------------------------------------
    | Reset Pagination
    |--------------------------------------------------------------------------
    */

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedWithdrawId()
    {
        $this->resetPage();
    }

    public function updatedClientId()
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

    public function updatedSendFrom()
    {
        $this->resetPage();
    }

    public function updatedSendTo()
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
            'withdrawId',
            'clientId',
            'createdFrom',
            'createdTo',
            'sendFrom',
            'sendTo',
        ]);

        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Update Status
    |--------------------------------------------------------------------------
    */

    public function updateStatus()
    {
        $this->validate([
            'selectedStatus' => 'required',
            'trxid' => 'required|string|max:100',
            'withdraw_doc' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () {

            $withdraw = Withdraw::lockForUpdate()
                ->findOrFail($this->selectedwithdrawId);

            // Keep old status so we don't process twice
            $oldStatus = $withdraw->status_id;

            /*
            |--------------------------------------------------------------------------
            | Upload New Withdraw Slip
            |--------------------------------------------------------------------------
            */

            if ($this->withdraw_doc) {

                if (
                    $withdraw->withdraw_doc &&
                    Storage::disk('public')->exists(
                        str_replace('storage/', '', $withdraw->withdraw_doc)
                    )
                ) {
                    Storage::disk('public')->delete(
                        str_replace('storage/', '', $withdraw->withdraw_doc)
                    );
                }

                $path = $this->withdraw_doc->store('withdraws', 'public');

                $withdraw->withdraw_doc = 'storage/' . $path;
            }

            /*
            |--------------------------------------------------------------------------
            | Update Withdraw
            |--------------------------------------------------------------------------
            */

            $withdraw->trxid = $this->trxid;
            $withdraw->status_id = $this->selectedStatus;
            $withdraw->send_at = now();

            $withdraw->save();

            /*
            |--------------------------------------------------------------------------
            | Client
            |--------------------------------------------------------------------------
            */

            $client = Client::lockForUpdate()
                ->findOrFail($withdraw->withdraw_by);

            /*
            |--------------------------------------------------------------------------
            | Rejected Withdraw
            |--------------------------------------------------------------------------
            |
            | Your existing logic adds the amount back to income_balance
            | when status becomes 3.
            |
            */

            if (
                $oldStatus != 3 &&
                $this->selectedStatus == 3
            ) {

                $client->increment(
                    'income_balance',
                    $withdraw->amount
                );

                /*
                |--------------------------------------------------------------------------
                | Send Email
                |--------------------------------------------------------------------------
                */

                if (
                    in_array($this->selectedStatus, [2, 3]) &&
                    !empty($client->email)
                ) {

                    Mail::to($client->email)
                        ->send(
                            new WithdrawStatusMail(
                                $withdraw,
                                $client,
                                $this->selectedStatus
                            )
                        );
                }
            }
        });

        $this->dispatch('closeStatusModal');

        $this->dispatch(
            'show-toast',
            message: 'Withdraw Status Updated Successfully'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Open Status Modal
    |--------------------------------------------------------------------------
    */

    public function openStatusModal($id)
    {
        $this->selectedwithdrawId = $id;

        $this->selectedwithdraw = Withdraw::with([
            'withdrawer',
            'account.operator.currency',
            'status'
        ])->findOrFail($id);

        $this->selectedStatus =
            $this->selectedwithdraw->status_id;

        $this->trxid =
            $this->selectedwithdraw->trxid;

        $this->withdraw_doc = null;

        $this->dispatch('openStatusModal');
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $query = Withdraw::query()
            ->with([
                'withdrawer',
                'account.operator.currency',
                'status'
            ]);

        /*
        |--------------------------------------------------------------------------
        | General Search
        |--------------------------------------------------------------------------
        |
        | Search:
        | - Transaction ID
        | - Client name
        | - Client phone
        | - Account number
        | - Operator
        |
        */

        if ($this->search) {

            $search = trim($this->search);

            $query->where(function ($q) use ($search) {

                $q->where('trxid', 'like', '%' . $search . '%')

                    ->orWhereHas('withdrawer', function ($clientQuery) use ($search) {

                        $clientQuery
                            ->where('name', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%');

                    })

                    ->orWhereHas('account', function ($accountQuery) use ($search) {

                        $accountQuery->where(
                            'account_no',
                            'like',
                            '%' . $search . '%'
                        );

                        $accountQuery->orWhereHas(
                            'operator',
                            function ($operatorQuery) use ($search) {

                                $operatorQuery->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                );

                            }
                        );
                    });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Withdraw ID
        |--------------------------------------------------------------------------
        */

        if ($this->withdrawId !== '') {

            $query->where(
                'id',
                $this->withdrawId
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Client ID
        |--------------------------------------------------------------------------
        */

        if ($this->clientId !== '') {

            $query->where(
                'withdraw_by',
                $this->clientId
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Created Date From
        |--------------------------------------------------------------------------
        */

        if ($this->createdFrom) {

            $query->whereDate(
                'created_at',
                '>=',
                $this->createdFrom
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Created Date To
        |--------------------------------------------------------------------------
        */

        if ($this->createdTo) {

            $query->whereDate(
                'created_at',
                '<=',
                $this->createdTo
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Send Date From
        |--------------------------------------------------------------------------
        */

        if ($this->sendFrom) {

            $query->whereDate(
                'send_at',
                '>=',
                $this->sendFrom
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Send Date To
        |--------------------------------------------------------------------------
        */

        if ($this->sendTo) {

            $query->whereDate(
                'send_at',
                '<=',
                $this->sendTo
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Totals
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Calculate totals before pagination.
        |
        */

        $totalAmount = (clone $query)
            ->sum('amount');

        $totalSendAmount = (clone $query)
            ->sum('send_amount');

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $withdraws = $query
            ->orderByDesc('id')
            ->paginate(25);

        return view(
            'livewire.withdraw.withdraw-crud',
            [
                'withdraws' => $withdraws,

                'totalAmount' => $totalAmount,

                'totalSendAmount' => $totalSendAmount,
            ]
        )->layout('layouts.app', [
            'title' => 'Withdraws',
            'sub_title' => 'Withdraws List'
        ]);
    }
}