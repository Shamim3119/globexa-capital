<?php

namespace App\Livewire\BussinessAccount;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Parameter;
use App\Models\BankOperator;
use App\Models\BussinessAccount;

class BussinessAccountCrud extends Component
{
    public $ref_id;
    public $ref_type_id = 0;
    public $bank_operators = [];
  
    public $operator_id;
    public $account_no;
    public $account_name;
    public $business_id;
    public $inactive = 0;

    public $account_id;
    public $updateMode = false;

 
    public function mount()
    {
        $this->bank_operators = BankOperator::all();
        $this->business_id = 1;
    }

    public function resetInputFields()
    {
        $this->account_id = null;
        $this->updateMode = false;

        $this->operator_id = null;
        $this->account_no = '';
        $this->account_name = '';
        $this->business_id = 1;
        $this->inactive = 0;
    }

    // ======================
    // EDIT FUNCTION
    // ======================
    public function edit($id)
    {
        $account = BussinessAccount::findOrFail($id);

        $this->account_id = $account->id;
        $this->updateMode = true;

        $this->operator_id = $account->operator_id;
        $this->account_no = $account->account_no;
        $this->account_name = $account->account_name;
        $this->business_id = $account->business_id;
        $this->inactive = $account->inactive;
    }

    // ======================
    // UPDATE FUNCTION
    // ======================
    public function update()
    {
        $this->validate([
            'operator_id' => 'required|exists:bank_operators,id',
            'account_id' => 'required',
            'account_name' => 'required',
            'business_id' => 'required',
        ]);

        $account = BussinessAccount::findOrFail($this->account_id);

        $account->update([
            'operator_id' => $this->operator_id,
            'account_no' => $this->account_no,
            'account_name' => $this->account_name,
            'business_id' => $this->business_id,
            'inactive' => $this->inactive ? 1 : 0,
        ]);


        $this->dispatch('show-toast', message: 'Bussiness Account Updated Successfully.');

        $this->resetInputFields();
    }

    public function store()
    {
        if ($this->updateMode) {
            return $this->update();
        }

        $this->validate([
            'operator_id' => 'required|exists:bank_operators,id',
            'account_name' => 'required',
            'account_no' => 'required',
            'business_id' => 'required',
        ]);

        BussinessAccount::create([
            'operator_id' => $this->operator_id,
            'account_no' => $this->account_no,
            'account_name' => $this->account_name,
            'business_id' => $this->business_id,
            'inactive' => $this->inactive ? 1 : 0,
        ]);

 
        $this->dispatch('show-toast', message: 'Account Created Successfully.');

        $this->resetInputFields();
    }

    public function delete($id)
    {
        BussinessAccount::findOrFail($id)->delete();

        $this->dispatch('show-toast', message: 'Business Account Deleted Successfully');
    }

    public function render()
    {
        $accounts = [];
    
        $accounts = BussinessAccount::with(['operator.currency'])
            ->get()
            ->map(function ($item) {
                $item->operator_name = $item->operator?->name;
                $item->currency_name = $item->operator?->currency?->name;
                return $item;
            });

        
    
        return view('livewire.bussiness-account.bussiness-account-crud', [
            'accounts' => $accounts
        ]);
    }
}