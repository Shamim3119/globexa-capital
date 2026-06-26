<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\GlobalSettings;

class RateCrud extends Component
{
    public $updateMode = false;
    public $activeTab = 'rate';

    public $global_settings;
    public $deposit_rate, $withdraw_rate; 

    public function mount()
    {
        $this->global_settings = GlobalSettings::where('id', 1)->first();
 
        $this->deposit_rate = $this->global_settings->deposit_rate;
        $this->withdraw_rate = $this->global_settings->withdraw_rate;
    }

    public function save()
    {
        $this->validate([
            'deposit_rate' => 'required|numeric',
            'withdraw_rate' => 'required|numeric',
        ]);

        $this->global_settings->update([
 
            'deposit_rate' => $this->deposit_rate,
            'withdraw_rate' => $this->withdraw_rate,  
        ]);

        $this->global_settings = $this->global_settings->fresh();

        $this->dispatch('show-toast', message: 'Rate updated successfully');
    }
 

    public function render()
    {
        return view('livewire.settings.rate-crud')->layout('layouts.app', [
            'title' => 'Settings',
            'sub_title' => 'Rate'
        ]);
 
    }
}
