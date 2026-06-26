<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\SalarySlot;

class SalarySlotCrud extends Component
{
    public $updateMode = false;
    public $activeTab = 'salary-slot';
 
    public $name, $left_amount,$right_amount, $salary_amount, $slot_id;
    public $salarySlots;

    private function resetInputFields()
    {
        $this->name = '';
        $this->left_amount = '';
        $this->right_amount = '';
        $this->salary_amount = '';
        $this->slot_id = null;
        
    }

    public function render()
    {
        $this->salarySlots = SalarySlot::orderBy('left_amount', 'asc')->get();

        return view('livewire.settings.salary-slot-crud')->layout('layouts.app', [
            'title' => 'Settings',
            'sub_title' => 'Salary Slot'
        ]);
 
    }

    public function store()
    {
        $validatedData = $this->validate([
            'name' => 'required|string',
            'left_amount' => 'required|numeric',
            'right_amount' => 'required|numeric',
            'salary_amount' => 'required|numeric',
 
        ]);



        if ($this->slot_id) {
            $salary = SalarySlot::find($this->slot_id);
            if ($salary) {
                $salary->update($validatedData);
                $this->dispatch('show-toast', message: 'Salary Slot Updated Successfully.');
            }
        } else {
            SalarySlot::create($validatedData);
            $this->dispatch('show-toast', message: 'Salary Slot  Created Successfully.');
        }

        $this->resetInputFields();
        $this->updateMode = false;
        $this->showForm = false;
    }

    public function edit($id)
    {
        $salary = SalarySlot::findOrFail($id);

        $this->name = $salary->name;
        $this->left_amount = $salary->left_amount;
        $this->right_amount = $salary->right_amount;
        $this->salary_amount = $salary->salary_amount;
        $this->slot_id = $id;

        $this->updateMode = true;
    }

    public function delete($id)
    {
        SalarySlot::find($id)?->delete();
        $this->dispatch('show-toast', 'Salary Slot Deleted Successfully.');
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