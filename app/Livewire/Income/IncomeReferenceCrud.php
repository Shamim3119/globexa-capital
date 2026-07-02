<?php

namespace App\Livewire\Income;

use Livewire\Component;
use App\Models\IncomeReference;

class IncomeReferenceCrud extends Component
{
    public $activeTab = 'reference';
    public $refIncomes;
    public function render()
    {

        $this->refIncomes = IncomeReference::with([
            'client',
            'investment.investor'
        ])->get();
 
        return view('livewire.income.income-reference-crud', [
            'refIncomes' => $this->refIncomes
        ])->layout('layouts.app', [
            'title' => 'Reference',
            'sub_title' => 'Reference List'
        ]);

 
    }
}
