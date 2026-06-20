<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\GlobalSettings;
use App\Models\GenerationCommission;

class GenerationCommissionCrud extends Component
{
    public $activeTab = 'generation-commission';

    public $gen_comm_level = 0;

    public $commissions = [];

    public function mount()
    {
        $settings = GlobalSettings::find(1);

        $this->gen_comm_level = $settings->gen_comm_level ?? 0;

        $existing = GenerationCommission::orderBy('level')->get();

        if ($existing->count()) {

            foreach ($existing as $row) {
                $this->commissions[$row->level] = $row->generation_commission;
            }

        } else {

            for ($i = 1; $i <= $this->gen_comm_level; $i++) {
                $this->commissions[$i] = '';
            }
        }
    }

    public function save()
    {
        $rules = [];

        for ($i = 1; $i <= $this->gen_comm_level; $i++) {
            $rules["commissions.$i"] = 'required|numeric|min:0';
        }

        $this->validate($rules);

        GenerationCommission::truncate();

        for ($i = 1; $i <= $this->gen_comm_level; $i++) {

            GenerationCommission::create([
                'level' => $i,
                'generation_commission' => $this->commissions[$i],
            ]);
        }

        $this->dispatch(
            'show-toast',
            message: 'Generation commissions updated successfully'
        );
    }

    public function render()
    {
        return view('livewire.settings.generation-commission-crud')
            ->layout('layouts.app', [
                'title' => 'Settings',
                'sub_title' => 'Generation Commission'
            ]);
    }
}