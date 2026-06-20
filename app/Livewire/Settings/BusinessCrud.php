<?php
 
namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Business;

class BusinessCrud extends Component
{
    use WithFileUploads;

    public $business;
    public $updateMode = false;
    public $activeTab = 'bussiness';

    public $id, $code, $name, $email, $phone, $address, $web;
    public $logo;

    // ✅ Load data once
    public function mount()
    {
        $this->business = Business::where('id', 1)->first();

        $this->id = $this->business->id;
        $this->code = $this->business->code;
        $this->name = $this->business->name;
        $this->email = $this->business->email;
        $this->phone = $this->business->phone;
        $this->address = $this->business->address;
        $this->web = $this->business->web;
    }

    public function edit($id)
    {
        $this->updateMode = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'logo' => 'nullable|image|max:1024', // max 1MB
        ]);

        $logoPath = $this->business->logo; // keep old logo

        if ($this->logo) {
            $logoPath = $this->logo->store('business', 'public');
        }

        $this->business->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'web' => $this->web,
            'logo' => $logoPath,
        ]);

        // ✅ refresh user data (optional but good)
        $this->business = $this->business->fresh();

        $this->dispatch('show-toast', message: 'Business updated successfully');
    }

    public function render()
    {
        return view('livewire.settings.business-crud')->layout('layouts.app', [
            'title' => 'Settings',
            'sub_title' => 'Business'
        ]);
 
    }
}