<?php

namespace App\Livewire\Refund;

use App\Models\Refund;
use App\Models\Client;
use App\Models\Investment;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class RefundCrud extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $updateMode = false;
    public $activeTab = 'refund';

    /*
    |--------------------------------------------------------------------------
    | Selected Refund
    |--------------------------------------------------------------------------
    */

    public $selectedRefundId;
    public $selectedStatus;
    public $selectedRefund;


    /*
    |--------------------------------------------------------------------------
    | Search / Filters
    |--------------------------------------------------------------------------
    */

    public $search = '';

    public $refundId = '';
    public $clientId = '';
    public $investmentId = '';

    public $createdFrom = '';
    public $createdTo = '';

    public $acceptFrom = '';
    public $acceptTo = '';


    /*
    |--------------------------------------------------------------------------
    | Reset Pagination When Filters Change
    |--------------------------------------------------------------------------
    */

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedRefundId()
    {
        $this->resetPage();
    }

    public function updatedClientId()
    {
        $this->resetPage();
    }

    public function updatedInvestmentId()
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
            'refundId',
            'clientId',
            'investmentId',
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
        $this->selectedRefundId = $id;

        $this->selectedStatus = '';

        $this->selectedRefund = Refund::with([
            'member',
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
            | Lock Refund
            |--------------------------------------------------------------------------
            */

            $refund = Refund::lockForUpdate()
                ->find($this->selectedRefundId);

            if (!$refund) {

                DB::rollBack();

                session()->flash(
                    'error',
                    'Refund not found.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Only Pending Refunds Can Be Updated
            |--------------------------------------------------------------------------
            */

            if ($refund->status_id != 1) {

                DB::rollBack();

                session()->flash(
                    'error',
                    'This refund has already been processed.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Update Refund Status
            |--------------------------------------------------------------------------
            */

            $refund->status_id = $this->selectedStatus;
            $refund->accept_at = now();
            $refund->save();


            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

            if ($this->selectedStatus == 2) {

                /*
                |--------------------------------------------------------------------------
                | Update Investment
                |--------------------------------------------------------------------------
                */

                $investment = Investment::lockForUpdate()
                    ->find($refund->investment_id);

                if ($investment) {

                    $investment->inactive = 1;
                    $investment->save();
                }


                /*
                |--------------------------------------------------------------------------
                | Update Client Balance
                |--------------------------------------------------------------------------
                */

                $client = Client::lockForUpdate()
                    ->find($refund->client_id);

                if ($client) {

                    $client->investment_balance -= $refund->amount;

                    $client->income_balance += $refund->return_amount;

                    $client->save();
                }
            }


            /*
            |--------------------------------------------------------------------------
            | REJECTED / CANCELLED
            |--------------------------------------------------------------------------
            */

            elseif ($this->selectedStatus == 3) {

                $investment = Investment::lockForUpdate()
                    ->find($refund->investment_id);

                if ($investment) {

                    $investment->inactive = 0;
                    $investment->save();
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
                message: 'Refund Status Updated Successfully'
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
        $query = Refund::query()
            ->with([
                'member',
                'status'
            ]);


        /*
        |--------------------------------------------------------------------------
        | General Search
        |--------------------------------------------------------------------------
        |
        | Search:
        | - Client name
        | - Client phone
        |
        */

        if ($this->search) {

            $search = trim($this->search);

            $query->where(function ($q) use ($search) {

                $q->whereHas(
                    'member',
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

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Refund ID
        |--------------------------------------------------------------------------
        */

        if ($this->refundId !== '') {

            $query->where(
                'id',
                $this->refundId
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Client ID
        |--------------------------------------------------------------------------
        */

        if ($this->clientId !== '') {

            $query->where(
                'client_id',
                $this->clientId
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Investment ID
        |--------------------------------------------------------------------------
        */

        if ($this->investmentId !== '') {

            $query->where(
                'investment_id',
                $this->investmentId
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
        | TOTAL AMOUNT
        |--------------------------------------------------------------------------
        */

        $totalAmount = (clone $query)
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | TOTAL CHARGE
        |--------------------------------------------------------------------------
        */

        $totalCharge = (clone $query)
            ->sum('charge');


        /*
        |--------------------------------------------------------------------------
        | TOTAL DEDUCT
        |--------------------------------------------------------------------------
        */

        $totalDeduct = (clone $query)
            ->sum('deduct');


        /*
        |--------------------------------------------------------------------------
        | TOTAL RETURN
        |--------------------------------------------------------------------------
        */

        $totalReturn = (clone $query)
            ->sum('return_amount');


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $refunds = $query
            ->orderByDesc('id')
            ->paginate(25);


        return view(
            'livewire.refund.refund-crud',
            [
                'refunds' => $refunds,

                'totalAmount' => $totalAmount,

                'totalCharge' => $totalCharge,

                'totalDeduct' => $totalDeduct,

                'totalReturn' => $totalReturn,
            ]
        )->layout('layouts.app', [
            'title' => 'Refund',
            'sub_title' => 'Refund List'
        ]);
    }
}