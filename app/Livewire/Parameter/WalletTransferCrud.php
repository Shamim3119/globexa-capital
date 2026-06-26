<?php
 

namespace App\Livewire\Parameter;

use Livewire\Component;
use App\Models\WalletTransfer;
use App\Models\WalletType;
use App\Models\Parameter;

class WalletTransferCrud extends Component
{


    public $wallet_transfers, $wallet_transfer_id, $inactive, $wallet_type_id, $transfer_type_id;
    public $wallet_types = [];
    public $transfer_types = [];
 
    public $updateMode = false;
    public $activeTab = 'wallet-type';

    public function mount()
    {
        $this->wallet_types = WalletType::all();
        $this->transfer_types = Parameter::where('tag', 'transfer-type')->get();

    
        if (request()->has('tab')) {
            $this->activeTab = request('tab');
        }
    }

    public function render()
    {
        $this->wallet_transfers = WalletTransfer::with([
            'transfer_type',
            'wallet_type'
        ])->get();

        return view('livewire.parameter.wallet-transfer-crud')
            ->layout('layouts.app', [
                'title' => 'Parameters',
                'sub_title' => 'Wallet Transfer'
            ]);

    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetInputFields();
        $this->updateMode = false;
    }

    private function resetInputFields()
    {
 
        $this->inactive = 0;
        $this->wallet_type_id = null;
        $this->transfer_type_id = null;
        $this->wallet_transfer_id = null;

    }


    public function store()
    {
        $validatedData = $this->validate([
            'inactive' => 'required|boolean',
            'wallet_type_id' => 'required|exists:wallet_types,id',
            'transfer_type_id' => 'required|exists:parameters,id',
        ]);

        $validatedData['tag'] = $this->activeTab;

        if ($this->wallet_transfer_id) {
            $wallet_transfer = WalletTransfer::find($this->wallet_transfer_id);
            if ($wallet_transfer) {
                $wallet_transfer->update($validatedData);
                $this->dispatch('show-toast', message: ucfirst($this->activeTab) . ' Updated Successfully.');
            }
        } else {
            WalletTransfer::create($validatedData);
            $this->dispatch('show-toast', message: ucfirst($this->activeTab) . ' Created Successfully.');
        }

        $this->resetInputFields();
        $this->updateMode = false;
        $this->showForm = false;
    }

    public function edit($id)
    {
        $wallet_transfer = WalletTransfer::findOrFail($id);

        $this->wallet_transfer_id = $id;
        $this->inactive = $wallet_transfer->inactive;
        $this->wallet_type_id = $wallet_transfer->wallet_type_id;
        $this->transfer_type_id = $wallet_transfer->transfer_type_id;

 
 
        $this->updateMode = true;
 
        // $this->dispatch('open-edit-box');
    }

    public function delete($id)
    {
        WalletTransfer::find($id)?->delete();
        $this->dispatch('show-toast', 'Wallet Transfer Deleted Successfully.');
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
 
    }

    public function create()
    {
        $this->resetInputFields();
        $this->updateMode = true;
 
    }
}
