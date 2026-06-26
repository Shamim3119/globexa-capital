<?php
 

namespace App\Livewire\Parameter;

use Livewire\Component;
use App\Models\WalletType;
use App\Models\BankOperator;

class WalletTypeCrud extends Component
{


    public $wallet_types, $name, $inactive, $operator_id, $wallet_type_id;
    public $bank_operator = [];
 
    public $updateMode = false;
    public $activeTab = 'wallet-type';

    public function mount()
    {
        $this->bank_operator = BankOperator::all();

    
        if (request()->has('tab')) {
            $this->activeTab = request('tab');
        }
    }

    public function render()
    {
        $this->wallet_types = WalletType::with([
            'bank_operator.currency'
        ])->get();

        return view('livewire.parameter.wallet-type-crud')
            ->layout('layouts.app', [
                'title' => 'Parameters',
                'sub_title' => 'Wallet Type'
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
        $this->name = '';
        $this->inactive = 0;
        $this->operator_id = null;
        $this->wallet_type_id = null;
    }


    public function store()
    {
        $validatedData = $this->validate([
            'name' => 'required|string',
            'inactive' => 'required|boolean',
            'operator_id' => 'required|exists:bank_operators,id',
        ]);

        $validatedData['tag'] = $this->activeTab;

        if ($this->wallet_type_id) {
            $bank_operator = WalletType::find($this->wallet_type_id);
            if ($bank_operator) {
                $bank_operator->update($validatedData);
                $this->dispatch('show-toast', message: ucfirst($this->activeTab) . ' Updated Successfully.');
            }
        } else {
            WalletType::create($validatedData);
            $this->dispatch('show-toast', message: ucfirst($this->activeTab) . ' Created Successfully.');
        }

        $this->resetInputFields();
        $this->updateMode = false;
        $this->showForm = false;
    }

    public function edit($id)
    {
        $wallet_type = WalletType::findOrFail($id);

        $this->wallet_type_id = $id;
        $this->inactive = $wallet_type->inactive;
        $this->name = $wallet_type->name;
        $this->operator_id = $wallet_type->operator_id;

        $this->updateMode = true;
 
        // $this->dispatch('open-edit-box');
    }

    public function delete($id)
    {
        BankOperator::find($id)?->delete();
        $this->dispatch('show-toast', 'Wallet Type Deleted Successfully.');
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
