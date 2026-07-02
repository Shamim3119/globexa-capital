<?php

namespace App\Livewire\Income;

use Livewire\Component;

class IncomeDailyCrud extends Component
{
    public $activeTab = 'daily';
    
    public function render()
    {
        return view('livewire.income.income-daily-crud');
    }
}
