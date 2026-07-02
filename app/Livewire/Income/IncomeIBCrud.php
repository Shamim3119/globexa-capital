<?php

namespace App\Livewire\Income;

use Livewire\Component;

class IncomeIBCrud extends Component
{

    public $activeTab = 'ib';


    public function render()
    {
        return view('livewire.income.income-ib-crud');
    }
}
