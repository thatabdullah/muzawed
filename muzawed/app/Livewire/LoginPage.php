<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginPage extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8',
    ];

    public function login()
    {
        $this->validate();

        $throttleKey = Str::lower($this->email) . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $this->addError('email', __('Too many login attempts. Please try again in :seconds seconds.', ['seconds' => RateLimiter::availableIn($throttleKey)]));
            return;
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password, 'account_id' => null, 'parent_id' => null, 'role' => 'member'], $this->remember)) {
            RateLimiter::clear($throttleKey);
            return redirect()->intended(route('home'));
        }

        RateLimiter::hit($throttleKey);
        $this->addError('email', __('These credentials do not match our records.'));
    }

    public function render()
    {
        return view('livewire.login-page')
            ->layout('components.layouts.app');
    }
}