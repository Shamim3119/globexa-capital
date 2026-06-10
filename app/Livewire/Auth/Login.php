<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;


class Login extends Component
{
    public $email, $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function login()
    {
        $this->validate();

        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password
        ])) {
            session()->regenerate();

            $user = Auth::user();
            $business = Business::find($user->business_id);

            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_image' => $user->image,
                'business_name' => $business?->name,
                'business_logo' => $business?->logo,
            ]);

            return redirect()->route('dashboard');
        }

        session()->flash('error', 'Invalid credentials');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.auth');
    }
}








