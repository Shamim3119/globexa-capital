<?php

namespace App\Livewire\Income;

use Livewire\Component;

class IncomeGenerationCrud extends Component
{
 
    public $activeTab = 'generation';

    public function render()
    {
        return view('livewire.income.income-generation-crud');
    }
}
