<?php

namespace App\Livewire\Transfer;

use Livewire\Component;
use App\Models\Transfer;


class TransferCrud extends Component
{
    public $transfers;
    public $updateMode = false;
    public $activeTab = 'transfer';

    public function render()
    {
        $this->transfers = Transfer::with([
            'member',
        ])->get();

        return view('livewire.transfer.transfer-crud', [
            'transfers' => $this->transfers
        ])->layout('layouts.app', [
            'title' => 'Transfer',
            'sub_title' => 'Transfer List'
        ]);
    }
}
