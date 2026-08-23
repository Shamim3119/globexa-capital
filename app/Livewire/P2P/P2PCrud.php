<?php

namespace App\Livewire\P2P;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\P2P;

class P2PCrud extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $updateMode = false;
    public $activeTab = 'p2p';

    /*
    |--------------------------------------------------------------------------
    | Search / Filters
    |--------------------------------------------------------------------------
    */

    public $search = '';

    public $p2pId = '';

    public $senderId = '';

    public $receiverId = '';

    public $createdFrom = '';

    public $createdTo = '';


    /*
    |--------------------------------------------------------------------------
    | Reset Pagination
    |--------------------------------------------------------------------------
    */

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedP2pId()
    {
        $this->resetPage();
    }

    public function updatedSenderId()
    {
        $this->resetPage();
    }

    public function updatedReceiverId()
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
            'p2pId',
            'senderId',
            'receiverId',
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
        $query = P2P::query()
            ->with([
                'sender',
                'receiver',
            ]);


        /*
        |--------------------------------------------------------------------------
        | General Search
        |--------------------------------------------------------------------------
        |
        | Searches both sender and receiver:
        | ID / name / phone
        |
        */

        if ($this->search) {

            $search = trim($this->search);

            $query->where(function ($q) use ($search) {

                $q->whereHas(
                    'sender',
                    function ($senderQuery) use ($search) {

                        $senderQuery
                            ->where('name', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%')
                            ->orWhere('id', $search);

                    }
                )

                ->orWhereHas(
                    'receiver',
                    function ($receiverQuery) use ($search) {

                        $receiverQuery
                            ->where('name', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%')
                            ->orWhere('id', $search);

                    }
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | P2P ID
        |--------------------------------------------------------------------------
        */

        if ($this->p2pId !== '') {

            $query->where(
                'id',
                $this->p2pId
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Sender ID
        |--------------------------------------------------------------------------
        */

        if ($this->senderId !== '') {

            $query->where(
                'sender_id',
                $this->senderId
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Receiver ID
        |--------------------------------------------------------------------------
        */

        if ($this->receiverId !== '') {

            $query->where(
                'receiver_id',
                $this->receiverId
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

        $p2ps = $query
            ->orderByDesc('id')
            ->paginate(25);


        return view(
            'livewire.p2-p.p2-p-crud',
            [
                'p2ps' => $p2ps,

                'totalAmount' => $totalAmount,
            ]
        )->layout('layouts.app', [
            'title' => 'P2P',
            'sub_title' => 'P2P List'
        ]);
    }
}