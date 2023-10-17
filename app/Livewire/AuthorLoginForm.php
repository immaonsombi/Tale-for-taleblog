<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthorLoginForm extends Component
{
    public $login_id, $password;
    public $returnUrl;


    public function mount()
    {
        $this->returnUrl = request()->returnUrl;
    }
    public function LoginHandler()
    {


        $fieldTypes = filter_var($this->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (
            $fieldTypes
            == 'email'
        ) {
            $this->validate([
                'login_id' => 'required|email|exists:users,email',
                'password' => 'required|min:5',
            ], [
                'login_id' => 'Email or Username must be provided',
                'login_id.email' => 'Invalid email address',
                'login_id.exists' => 'Email is not registered',
                'password.required' => 'Password must be filled',
            ]);
        } else {
            $this->validate(
                [
                    'login_id' => 'required|exists:users,username',
                    'password' => 'required|min:5',
                ],
                [
                    'login_id.required' => 'Email or Username is required',
                    'login_id.exists' => 'Username is not registered',
                    'password.required' => 'Password is required',
                ]
            );
        }
        $creds = array($fieldTypes => $this->login_id, 'password' => $this->password);
        if (Auth::guard('web')->attempt($creds)) {
            $checkUser = User::where($fieldTypes, $this->login_id)->first();
            if ($checkUser->blocked == 1) {
                Auth::guard('web')->logout();
                return redirect()->route('author.login')->with('fail', 'Your account has been locked');
            } else {
                //return redirect()->route('author.home');
                if ($this->returnUrl !== null) {
                    return redirect()->to($this->returnUrl);
                } else {
                    redirect()->route('author.home');
                }
            }
        } else {
            session()->flash('fail', 'Incorrect email/Username or password');
        }
    }


    public function render()
    {
        return view('livewire.author-login-form');
    }
}
