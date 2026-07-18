<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\GlobalSettings;

class GlobalSettingsCrud extends Component
{
    public $global_settings;
    public $activeTab = 'global-settings';
    public $ref_comm, $ivr_com, $gen_comm_level, $dep_comm_level, $inv_charge_level; 
    public $min_deposit, $min_activation, $min_withdrawal, $max_deposit, $max_activation, $max_withdrawal; 
    public $min_p2p, $max_p2p, $min_transfer, $max_transfer;

    public function mount()
    {
        $this->global_settings = GlobalSettings::where('id', 1)->first();

        $this->gen_comm_level = $this->global_settings->gen_comm_level;

        $this->min_deposit = $this->global_settings->min_deposit;
        $this->min_activation = $this->global_settings->min_activation;
        $this->min_withdrawal = $this->global_settings->min_withdrawal;

        $this->max_deposit = $this->global_settings->max_deposit;
        $this->max_activation = $this->global_settings->max_activation;
        $this->max_withdrawal = $this->global_settings->max_withdrawal;
        $this->dep_comm_level = $this->global_settings->dep_comm_level;
        $this->inv_charge_level = $this->global_settings->inv_charge_level;

        $this->min_p2p = $this->global_settings->min_p2p;
        $this->max_p2p = $this->global_settings->max_p2p;
        $this->min_transfer = $this->global_settings->min_transfer;
        $this->max_transfer = $this->global_settings->max_transfer;
 

        
        $this->ivr_com = $this->global_settings->ivr_com;

        $this->ref_comm = $this->global_settings->ref_comm;

        

 
    }

    public function save()
    {
        $this->validate([
 
            'ref_comm' => 'required|numeric',
            'gen_comm_level' => 'required|numeric',
            'dep_comm_level' => 'required|numeric',
            'inv_charge_level' => 'required|numeric',
            
            'ivr_com' => 'required|numeric',
            
            'min_deposit' => 'required|numeric',
            'min_activation' => 'required|numeric',
            'min_withdrawal' => 'required|numeric',

            'max_deposit' => 'required|numeric',
            'max_activation' => 'required|numeric',
            'max_withdrawal' => 'required|numeric',

            'min_p2p' => 'required|numeric',
            'max_p2p' => 'required|numeric',
            'min_transfer' => 'required|numeric',
            'max_transfer' => 'required|numeric',
        ]);




        $this->global_settings->update([
 
            'ref_comm' => $this->ref_comm,
            'gen_comm_level' => $this->gen_comm_level,
            'min_deposit' => $this->min_deposit,
            'min_activation' => $this->min_activation,
            'min_withdrawal' => $this->min_withdrawal,
            'max_deposit' => $this->max_deposit,
            'max_activation' => $this->max_activation,
            'max_withdrawal' => $this->max_withdrawal,
            'dep_comm_level' => $this->dep_comm_level,
            'inv_charge_level' => $this->inv_charge_level,
            
            'ivr_com' => $this->ivr_com,

            'min_p2p' => $this->min_p2p,
            'max_p2p' => $this->max_p2p,
            'min_transfer' => $this->min_transfer,
            'max_transfer' => $this->max_transfer,
            
            
        ]);

        $this->global_settings = $this->global_settings->fresh();

        $this->dispatch('show-toast', message: 'Global settings updated successfully');
    }
 
    
    public function render()
    {
        return view('livewire.settings.global-settings-crud')->layout('layouts.app', [
            'title' => 'Settings',
            'sub_title' => 'Global Settings'
        ]);
    }
}
