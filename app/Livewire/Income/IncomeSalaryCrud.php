<?php

namespace App\Livewire\Income;

use Livewire\Component;

class IncomeSalaryCrud extends Component
{

    public $activeTab = 'salary';

    public function render()
    {
        return view('livewire.income.income-salary-crud');
    }
}
