<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\GlobalSettings;
use App\Models\DepositeCommission;

class DepositeCommissionCrud extends Component
{
    public $activeTab = 'investment-commission';

    public $dep_comm_level = 0;

    public $commissions = [];

    public $days = [];

    public function mount()
    {
        $settings = GlobalSettings::find(1);

        $this->dep_comm_level = $settings->dep_comm_level ?? 0;

        $existing = DepositeCommission::orderBy('level')->get();

        if ($existing->count()) {

            foreach ($existing as $row) {
                $this->commissions[$row->level] = $row->deposite_commission;
                $this->days[$row->level] = $row->day;
            }

        } else {

            for ($i = 1; $i <= $this->dep_comm_level; $i++) {
                $this->commissions[$i] = '';
                $this->days[$i] = '';
            }
        }
    }

    public function save()
    {
        $rules = [];

        for ($i = 1; $i <= $this->dep_comm_level; $i++) {
            $rules["commissions.$i"] = 'required|numeric|min:0';
            $rules["days.$i"] = 'required|numeric|min:0';
        }

        $this->validate($rules);

        DepositeCommission::truncate();

        for ($i = 1; $i <= $this->dep_comm_level; $i++) {

            DepositeCommission::create([
                'level' => $i,
                'day' => $this->days[$i],
                'deposite_commission' => $this->commissions[$i],
            ]);
        }

        $this->dispatch(
            'show-toast',
            message: 'Deposite commissions updated successfully'
        );
    }


    public function render()
    {
        return view('livewire.settings.deposite-commission-crud')
            ->layout('layouts.app', [
                'title' => 'Settings',
                'sub_title' => 'Deposite Commission'
            ]);
 
    }
}
