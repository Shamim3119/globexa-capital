<?php

namespace App\Livewire\Parameter;

use Livewire\Component;
use App\Models\BankOperator;
use App\Models\Parameter;

class BankOperatorCrud extends Component
{


    public $bank_operators, $name, $inactive, $bank_operator_id, $type_id, $currency_id;
    public $bank_types = [];
    public $currencies = [];
    public $updateMode = false;
    public $activeTab = 'bank-operator';

    public function mount()
    {
        $this->bank_types = Parameter::where('tag', 'banking-type')->get();
        $this->currencies = Parameter::where('tag', 'currency')->get();

    
        if (request()->has('tab')) {
            $this->activeTab = request('tab');
        }
    }

    public function render()
    {

        $this->bank_operators = BankOperator::all();

        return view('livewire.parameter.bank-operator-crud')
            ->layout('layouts.app', [
                'title' => 'Bank Operators',
                'sub_title' => 'Bank Operators List'
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
        $this->bank_operator_id = null;
    }


    public function store()
    {
        $validatedData = $this->validate([
            'name' => 'required|string',
            'inactive' => 'required|boolean',
            'type_id' => 'required|exists:parameters,id',
            'currency_id' => 'required|exists:parameters,id'
        ]);

        $validatedData['tag'] = $this->activeTab;

        if ($this->bank_operator_id) {
            $bank_operator = BankOperator::find($this->bank_operator_id);
            if ($bank_operator) {
                $bank_operator->update($validatedData);
                $this->dispatch('show-toast', message: ucfirst($this->activeTab) . ' Updated Successfully.');
            }
        } else {
            BankOperator::create($validatedData);
            $this->dispatch('show-toast', message: ucfirst($this->activeTab) . ' Created Successfully.');
        }

        $this->resetInputFields();
        $this->updateMode = false;
        $this->showForm = false;
    }

    public function edit($id)
    {
        $bank_operator = BankOperator::findOrFail($id);

        $this->bank_operator_id = $id;
        $this->inactive = $bank_operator->inactive;
        $this->name = $bank_operator->name;
        $this->type_id = $bank_operator->type_id;
        $this->currency_id = $bank_operator->currency_id;
        $this->updateMode = true;
 
        // $this->dispatch('open-edit-box');
    }

    public function delete($id)
    {
        BankOperator::find($id)?->delete();
        $this->dispatch('show-toast', 'Bank Operator Deleted Successfully.');
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
