<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthorChangePasswordForm extends Component
{

    public $new_password, $confirm_new_password, $current_password;


    public function changePassword()
    {
        $this->validate([
            'current_password' => [
                'required' => function ($attribute, $value, $fail) {
                    if (!Hash::check($value, User::find(auth('web')->id())->password)) {
                        return $fail(__('Invalid password'));
                    }
                },
            ],
            'new_password' => 'required|min:5|max:25',
            'confirm_new_password' => 'same:new_password'
        ], [

            'current_password.required' => 'Enter Your current password',
            'new_password.required' => 'Enter your new password',
            'confirm_new_password.required' => 'The confirm password must be the same as the new password',
        ]);

        $query = User::find(auth('web')->id())->update([
            'password' => Hash::make($this->new_password)
        ]);
        if ($query) {
            $this->showToastr('Your new password has been successfully updated.', 'success');
            $this->current_password = $this->new_password = $this->confirm_new_password = null;
        } else {
            $this->showToastr('Something went wrong', 'Error');
        }
    }
    public function showToastr($message, $type)
    {
        return $this->dispatchBrowserEvent('showToastr', [
            $type => $type,
            'message' => $message

        ]);
    }
    public function render()
    {
        return view('livewire.author-change-password-form');
    }
}
