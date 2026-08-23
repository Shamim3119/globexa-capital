<?php

namespace App\Livewire\Deposit;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Deposit;
use App\Models\Client;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Mail\DepositStatusMail;

class DepositCrud extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $updateMode = false;
    public $activeTab = 'deposit';

    /*
    |--------------------------------------------------------------------------
    | Selected Deposit
    |--------------------------------------------------------------------------
    */

    public $selectedDepositId;
    public $selectedStatus;
    public $selectedDeposit;


    /*
    |--------------------------------------------------------------------------
    | Search / Filters
    |--------------------------------------------------------------------------
    */

    public $search = '';

    public $depositId = '';
    public $clientId = '';

    public $createdFrom = '';
    public $createdTo = '';

    public $acceptFrom = '';
    public $acceptTo = '';


    /*
    |--------------------------------------------------------------------------
    | Reset Pagination
    |--------------------------------------------------------------------------
    */

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedDepositId()
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

    public function updatedAcceptFrom()
    {
        $this->resetPage();
    }

    public function updatedAcceptTo()
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
            'depositId',
            'clientId',
            'createdFrom',
            'createdTo',
            'acceptFrom',
            'acceptTo',
        ]);

        $this->resetPage();
    }


    /*
    |--------------------------------------------------------------------------
    | Open Status Modal
    |--------------------------------------------------------------------------
    */

    public function openStatusModal($id)
    {
        $this->selectedDepositId = $id;

        $this->selectedStatus = '';

        $this->selectedDeposit = Deposit::with([
            'depositer',
            'account.operator.currency',
            'status'
        ])->findOrFail($id);

        $this->dispatch('openStatusModal');
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
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Lock Deposit
            |--------------------------------------------------------------------------
            */

            $deposit = Deposit::lockForUpdate()
                ->find($this->selectedDepositId);

            if (!$deposit) {

                DB::rollBack();

                session()->flash(
                    'error',
                    'Deposit not found.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Only Pending Deposits
            |--------------------------------------------------------------------------
            */

            if ($deposit->status_id != 1) {

                DB::rollBack();

                session()->flash(
                    'error',
                    'This deposit has already been processed.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Update Status
            |--------------------------------------------------------------------------
            */

            $deposit->status_id = $this->selectedStatus;
            $deposit->accept_at = now();

            $deposit->save();


            /*
            |--------------------------------------------------------------------------
            | Client
            |--------------------------------------------------------------------------
            */

            $client = Client::lockForUpdate()
                ->find($deposit->deposit_by);


            /*
            |--------------------------------------------------------------------------
            | Accepted
            |--------------------------------------------------------------------------
            */

            if (
                $this->selectedStatus == 2 &&
                $client
            ) {

                $client->increment(
                    'deposit_balance',
                    $deposit->amount
                );


                /*
                |--------------------------------------------------------------------------
                | Email
                |--------------------------------------------------------------------------
                */

                if (!empty($client->email)) {

                    Mail::to($client->email)
                        ->send(
                            new DepositStatusMail(
                                $deposit,
                                $client,
                                $this->selectedStatus
                            )
                        );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Commit
            |--------------------------------------------------------------------------
            */

            DB::commit();


            $this->dispatch('closeStatusModal');


            $this->dispatch(
                'show-toast',
                message: 'Deposit Status Updated Successfully'
            );

        } catch (\Exception $e) {

            DB::rollBack();

            session()->flash(
                'error',
                $e->getMessage()
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $query = Deposit::query()
            ->with([
                'depositer',
                'account.operator.currency',
                'status'
            ]);


        /*
        |--------------------------------------------------------------------------
        | General Search
        |--------------------------------------------------------------------------
        |
        | Searches:
        | - TRX ID
        | - Client name
        | - Client phone
        | - Account number
        | - Operator name
        |
        */

        if ($this->search) {

            $search = trim($this->search);

            $query->where(function ($q) use ($search) {

                /*
                |--------------------------------------------------------------------------
                | TRX ID
                |--------------------------------------------------------------------------
                */

                $q->where(
                    'trxid',
                    'like',
                    '%' . $search . '%'
                );


                /*
                |--------------------------------------------------------------------------
                | Client
                |--------------------------------------------------------------------------
                */

                $q->orWhereHas(
                    'depositer',
                    function ($clientQuery) use ($search) {

                        $clientQuery
                            ->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            )
                            ->orWhere(
                                'phone',
                                'like',
                                '%' . $search . '%'
                            );

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Account
                |--------------------------------------------------------------------------
                */

                $q->orWhereHas(
                    'account',
                    function ($accountQuery) use ($search) {

                        $accountQuery->where(
                            'account_no',
                            'like',
                            '%' . $search . '%'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | Operator
                        |--------------------------------------------------------------------------
                        */

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
                    }
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Deposit ID
        |--------------------------------------------------------------------------
        */

        if ($this->depositId !== '') {

            $query->where(
                'id',
                $this->depositId
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Client ID
        |--------------------------------------------------------------------------
        */

        if ($this->clientId !== '') {

            $query->where(
                'deposit_by',
                $this->clientId
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Created From
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
        | Created To
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
        | Accept From
        |--------------------------------------------------------------------------
        */

        if ($this->acceptFrom) {

            $query->whereDate(
                'accept_at',
                '>=',
                $this->acceptFrom
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Accept To
        |--------------------------------------------------------------------------
        */

        if ($this->acceptTo) {

            $query->whereDate(
                'accept_at',
                '<=',
                $this->acceptTo
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Total Amount
        |--------------------------------------------------------------------------
        |
        | Clone the filtered query BEFORE pagination.
        |
        */

        $totalAmount = (clone $query)
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | Total Exchange Amount
        |--------------------------------------------------------------------------
        */

        $totalExchangeAmount = (clone $query)
            ->sum('exchange_amount');


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $deposits = $query
            ->orderByDesc('id')
            ->paginate(25);


        return view(
            'livewire.deposit.deposit-crud',
            [
                'deposits' => $deposits,

                'totalAmount' => $totalAmount,

                'totalExchangeAmount' => $totalExchangeAmount,
            ]
        )->layout('layouts.app', [
            'title' => 'Deposit',
            'sub_title' => 'Deposit List'
        ]);
    }
}