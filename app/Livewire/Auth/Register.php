<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class Register extends Component
{   
    public $username;
    public $email;
    public $password;
    public $confirm_password;
    public $showPassword;


    protected $rules = [
        'username' => ['required', 'string', 'min:6', 'max:255', 'unique:users'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 
            'regex:/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/'],
        'confirm_password' => ['required', 'same:password'],
    ];

    protected $messages = [
        'password.regex' => 'Password must be at least 8 characters and 
        contain at least one number and one special character.',
        'confirm_password.regex' => 'Confirm password must be at least 8 characters and
        contain at least one number and one special character.'
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        event(new Registered($user));

        auth()->login($user);

        return redirect()->intended('/');
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function render()
    {
        return view('livewire.auth.register')->extends('layouts.auth');
    }
}
