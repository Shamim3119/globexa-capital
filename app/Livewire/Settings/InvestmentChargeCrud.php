<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\GlobalSettings;
use App\Models\InvestmentCharge;

class InvestmentChargeCrud extends Component
{
    public $activeTab = 'investment-charge';

    public $inv_charge_level = 0;

    public $charges = [];

    public $days = [];

    public function mount()
    {
        $settings = GlobalSettings::find(1);

        $this->inv_charge_level = $settings->inv_charge_level ?? 0;

        $existing = InvestmentCharge::orderBy('level')->get();

        if ($existing->count()) {

            foreach ($existing as $row) {
                $this->charges[$row->level] = $row->charge;
                $this->days[$row->level] = $row->day;
            }

        } else {

            for ($i = 1; $i <= $this->inv_charge_level; $i++) {
                $this->charges[$i] = '';
                $this->days[$i] = '';
            }
        }
    }

    public function save()
    {
        $rules = [];

        for ($i = 1; $i <= $this->inv_charge_level; $i++) {
            $rules["charges.$i"] = 'required|numeric|min:0';
            $rules["days.$i"] = 'required|numeric|min:0';
        }

        $this->validate($rules);

        InvestmentCharge::truncate();

        for ($i = 1; $i <= $this->inv_charge_level; $i++) {

            InvestmentCharge::create([
                'level' => $i,
                'day' => $this->days[$i],
                'charge' => $this->charges[$i],
            ]);
        }

        $this->dispatch(
            'show-toast',
            message: 'Investment charges updated successfully'
        );
    }

    public function render()
    {
        return view('livewire.settings.investment-charge-crud')
            ->layout('layouts.app', [
                'title' => 'Settings',
                'sub_title' => 'Investment Charge'
            ]);
    }
}