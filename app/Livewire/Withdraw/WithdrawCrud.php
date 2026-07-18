<?php

namespace App\Livewire\Withdraw;

use Livewire\Component;
use App\Models\Withdraw;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class WithdrawCrud extends Component
{
    use WithFileUploads;

    public $withdraws;
    public $updateMode = false;
    public $activeTab = 'withdraw';

    public $selectedwithdrawId;
    public $selectedStatus;
    public $selectedwithdraw;  

    public $trxid;
    public $withdraw_doc;



    public function updateStatus()
    {
        $this->validate([
            'selectedStatus' => 'required',
            'trxid' => 'required|string|max:100',
            'withdraw_doc' => 'nullable|image|max:2048',
        ]);

        $withdraw = Withdraw::findOrFail($this->selectedwithdrawId);

        if ($this->withdraw_doc) {

            if ($withdraw->withdraw_doc &&
                Storage::disk('public')->exists($withdraw->withdraw_doc)) {

                Storage::disk('public')->delete($withdraw->withdraw_doc);
            }

            $path = $this->withdraw_doc->store('withdraws', 'public');

            $withdraw->withdraw_doc = 'storage/'.$path;
        }

        $withdraw->trxid = $this->trxid;
        $withdraw->status_id = $this->selectedStatus;
        $withdraw->send_at = now();

        $withdraw->save();

        $this->dispatch('closeStatusModal');
    }


    public function openStatusModal($id)
    {
        $this->selectedwithdrawId = $id;

        $this->selectedwithdraw = Withdraw::with([
            'withdrawer',
            'account.operator.currency',
            'status'
        ])->findOrFail($id);

        $this->selectedStatus = $this->selectedwithdraw->status_id;
        $this->trxid = $this->selectedwithdraw->trxid;
        $this->withdraw_doc = null;

        $this->dispatch('openStatusModal');
    }



 

    public function render()
    {
        $this->withdraws = Withdraw::with([
            'withdrawer',
            'account.operator.currency',
            'status'
        ])->get();

        return view('livewire.withdraw.withdraw-crud', [
            'withdraws' => $this->withdraws
        ])->layout('layouts.app', [
            'title' => 'Withdraws',
            'sub_title' => 'Withdraws List'
        ]);
    }
    
}
