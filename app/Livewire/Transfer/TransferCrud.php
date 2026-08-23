<?php

namespace App\Livewire\Transfer;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Transfer;

class TransferCrud extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $updateMode = false;
    public $activeTab = 'transfer';

    /*
    |--------------------------------------------------------------------------
    | Search / Filters
    |--------------------------------------------------------------------------
    */

    public $search = '';

    public $transferId = '';
    public $clientId = '';

    public $createdFrom = '';
    public $createdTo = '';


    /*
    |--------------------------------------------------------------------------
    | Reset Pagination When Filter Changes
    |--------------------------------------------------------------------------
    */

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedTransferId()
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


    /*
    |--------------------------------------------------------------------------
    | Clear Filters
    |--------------------------------------------------------------------------
    */

    public function clearFilters()
    {
        $this->reset([
            'search',
            'transferId',
            'clientId',
            'createdFrom',
            'createdTo',
        ]);

        $this->resetPage();
    }


    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $query = Transfer::query()
            ->with([
                'member',
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
        | Transfer ID
        |--------------------------------------------------------------------------
        */

        if ($this->transferId !== '') {

            $query->where(
                'id',
                $this->transferId
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Client ID
        |--------------------------------------------------------------------------
        */

        if ($this->clientId !== '') {

            $query->where(
                'transfer_by',
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
        | Total Amount
        |--------------------------------------------------------------------------
        */

        $totalAmount = (clone $query)
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $transfers = $query
            ->orderByDesc('id')
            ->paginate(25);


        return view(
            'livewire.transfer.transfer-crud',
            [
                'transfers' => $transfers,

                'totalAmount' => $totalAmount,
            ]
        )->layout('layouts.app', [
            'title' => 'Transfer',
            'sub_title' => 'Transfer List'
        ]);
    }
}