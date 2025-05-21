<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Account;

class RegisterPage extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $password = '';
    public $password_confirmation = '';
    public $otp = '';
    public $showOtpInput = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|regex:/^\+966[0-9]{8,9}$/|unique:users,phone',
        'password' => 'required|min:8|confirmed',
        'otp' => 'required_if:showOtpInput,true|digits:4',
    ];

    public function sendOtp()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^\+966[0-9]{8,9}$/|unique:users,phone',
            'password' => 'required|min:8|confirmed',
        ]);

        $throttleKey = Str::lower($this->email) . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $this->addError('email', __('Too many attempts. Please try again in :seconds seconds.', [
                'seconds' => RateLimiter::availableIn($throttleKey)
            ]));
            return;
        }

        $apiKey = env('AUTHENTICA_API_KEY');
        if (empty($apiKey)) {
            $this->addError('phone', __('API key is missing. Please contact support.'));
            return;
        }

        try {
            $response = Http::withHeaders([
                'X-Authorization' => $apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://api.authentica.sa/api/v1/send-otp', [
                'phone' => $this->phone,
                'method' => 'sms',
                'otp_format' => 'numeric',
                'number_of_digits' => 4,
            ]);

            if ($response->successful()) {
                session(['otp_phone' => $this->phone]);
                $this->showOtpInput = true;
                $this->dispatch('otp-sent', message: __('OTP sent successfully'));
            } else {
                RateLimiter::hit($throttleKey);
                $this->addError('phone', __('Failed to send OTP'));
            }
        } catch (\Exception $e) {
            RateLimiter::hit($throttleKey);
            $this->addError('phone', __('Failed to send OTP'));
        }
    }

    public function register()
    {
        try {
            $this->validate([
                'otp' => 'required|digits:4',
            ]);

            $throttleKey = Str::lower($this->email) . '|' . request()->ip();
            if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
                $this->addError('otp', __('Too many attempts. Please try again in :seconds seconds.', [
                    'seconds' => RateLimiter::availableIn($throttleKey)
                ]));
                return;
            }

            $sessionPhone = session('otp_phone');
            if (!$sessionPhone || $sessionPhone !== $this->phone) {
                $this->addError('otp', __('Phone number mismatch. Please try again.'));
                return;
            }

            $apiKey = env('AUTHENTICA_API_KEY');
            if (empty($apiKey)) {
                $this->addError('otp', __('API key is missing. Please contact support.'));
                return;
            }

            $response = Http::withHeaders([
                'X-Authorization' => $apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://api.authentica.sa/api/v1/verify-otp', [
                'phone' => $sessionPhone,
                'otp' => $this->otp,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['status']) && in_array($responseData['status'], ['success', 'approved', 'verified'])) {
                    $accountId = env('DEFAULT_ACCOUNT_ID', 1);
                    if (!Account::where('id', $accountId)->exists()) {
                        $this->addError('otp', __('Invalid account configuration. Please contact support.'));
                        return;
                    }

                    $user = User::create([
                        'name' => $this->name,
                        'email' => $this->email,
                        'phone' => $sessionPhone,
                        'password' => Hash::make($this->password),
                        'account_id' => $accountId,
                        'parent_id' => null,
                        'role' => 'member',
                    ]);

                    RateLimiter::clear($throttleKey);
                    auth()->login($user);
                    session()->forget('otp_phone');
                    return redirect()->route('home', ['locale' => app()->getLocale()]);
                } else {
                    $this->addError('otp', __('Invalid OTP or verification failed: :message', [
                        'message' => $responseData['message'] ?? 'Unknown error'
                    ]));
                    RateLimiter::hit($throttleKey);
                }
            } else {
                $this->addError('otp', __('Failed to verify OTP. Please try again.'));
                RateLimiter::hit($throttleKey);
            }
        } catch (\Exception $e) {
            $this->addError('otp', __('Failed to verify OTP due to an error. Please try again.'));
        }
    }

    public function render()
    {
        return view('livewire.register-page')
            ->layout('components.layouts.app');
    }
}