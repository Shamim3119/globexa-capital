<?php

namespace App\Livewire\Settings;

use Livewire\Component;

use Livewire\WithFileUploads;
use App\Models\User;


class ProfileCrud extends Component
{
    use WithFileUploads;


    public $user;
    public $activeTab = 'profile';
    public $name, $email, $phone, $address;
    public $image;

    // ✅ Load data once
    public function mount()
    {
        $this->user = auth()->user();

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->address = $this->user->address;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'image' => 'nullable|image|max:1024', // max 1MB
        ]);

        $imagePath = $this->user->image; // keep old image

        if ($this->image) {
            $imagePath = $this->image->store('profile', 'public');
        }

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'image' => $imagePath,
        ]);

        $this->user = $this->user->fresh();

        $this->dispatch('show-toast', message: 'Profile updated successfully');
    }

    public function render()
    {
        return view('livewire.settings.profile-crud')->layout('layouts.app', [
            'title' => 'Settings',
            'sub_title' => 'User Profile'
        ]);
    }
}