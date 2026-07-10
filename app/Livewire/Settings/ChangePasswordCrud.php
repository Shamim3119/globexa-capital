<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ChangePasswordCrud extends Component
{
    public $activeTab = 'change-password';

    public $existing_password;
    public $new_password;
    public $new_password_confirmation;

    protected function rules()
    {
        return [
            'existing_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ];
    }

    public function save()
    {
        $this->validate();

        $user = User::find(Auth::id());

        // Verify existing password
        if (!Hash::check($this->existing_password, $user->password)) {
            $this->addError('existing_password', 'Existing password is incorrect.');
            return;
        }

        // Prevent using the same password
        if (Hash::check($this->new_password, $user->password)) {
            $this->addError('new_password', 'New password must be different from the current password.');
            return;
        }

        // Update password
        $user->password = Hash::make($this->new_password);
        $user->save();

        // Clear form
        $this->reset([
            'existing_password',
            'new_password',
            'new_password_confirmation'
        ]);


        $this->dispatch('show-toast', message: 'Password changed successfully.');
 
    }

    public function render()
    {
        return view('livewire.settings.change-password-crud');
    }
}