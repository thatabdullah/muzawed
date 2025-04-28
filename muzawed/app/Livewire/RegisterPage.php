<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class RegisterPage extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ];

    public function register()
    {
        $this->validate();

        $throttleKey = Str::lower($this->email) . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $this->addError('email', __('Too many registration attempts. Please try again in :seconds seconds.', ['seconds' => RateLimiter::availableIn($throttleKey)]));
            return;
        }

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'account_id' => null,
            'parent_id' => null,
            'role' => 'member',
        ]);

        RateLimiter::clear($throttleKey);
        auth()->login($user);

        return redirect()->route('home', ['locale' => app()->getLocale()]);
    }

    public function render()
    {
        return view('livewire.register-page')
            ->layout('components.layouts.app');
    }
}