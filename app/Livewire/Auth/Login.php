<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;


class Login extends Component
{
    public $usernameOrEmail;
    public $password;
    public $remember = false;
    public $showPassword = false;


    // @var int
    // The maximum number of attempts to allow.
    protected $maxAttempts = 3;
    // The number of minutes to throttle for.
    protected $decaySeconds = 60;
    // Maximum 3 login attempts in 1 minute


    protected $rules = [
        'usernameOrEmail' => 'required|string',
        'password' => 'required|string',
    ];

    public function login(Request $request)
    {
        $this->validate();

        $field = filter_var($this->usernameOrEmail, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field => $this->usernameOrEmail,
            'password' => $this->password,
        ];
        $throttleKey = "login.".request()->ip();
       
        if (RateLimiter::tooManyAttempts($throttleKey, $this->maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            session()->flash('danger', 'Too many login attempts. Please try again in '.$seconds.' seconds.');
            return;
        }

        if (Auth::attempt($credentials, $this->remember)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            if (Auth::user()->role == 'admin') { // Check if the user has an admin role
                $username = Auth::user()->username;
                return redirect('/admin/dashboard')->with('success', 'Welcome back, ' . $username); // Redirect to the admin panel
            } else {
                return redirect('/');
            }
        }

        RateLimiter::hit($throttleKey,$this->decaySeconds);
        $attemptsLeft = RateLimiter::retriesLeft($throttleKey, $this->maxAttempts);
        session()->flash('attemptsLeft', $attemptsLeft);
        session()->flash('danger', "These credentials do not match our records.");
    }

    public function hide()
    {
        session()->forget('danger');
    }


    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.auth');
    }
}
