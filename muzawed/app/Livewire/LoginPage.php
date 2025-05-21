<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class LoginPage extends Component
{
    public $phone = '';
    public $otp = '';
    public $showOtpInput = false;

    protected $rules = [
        'phone' => 'required|regex:/^\+966[0-9]{8,9}$/',
        'otp' => 'required_if:showOtpInput,true|digits:4',
    ];

    public function sendOtp()
    {
        $this->validate(['phone' => 'required|regex:/^\+966[0-9]{8,9}$/']);

        $throttleKey = Str::lower($this->phone) . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $this->addError('phone', __('Too many attempts. Please try again in :seconds seconds.', [
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

    public function verifyOtp()
    {
        try {
            $this->validate(['otp' => 'required|digits:4']);

            $throttleKey = Str::lower($this->phone) . '|' . request()->ip();
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
                    $user = \App\Models\User::where('phone', $sessionPhone)->first();
                    if ($user) {
                        Auth::login($user);
                        RateLimiter::clear($throttleKey);
                        session()->forget('otp_phone');
                        return redirect()->intended(route('home', ['locale' => app()->getLocale()]));
                    }
                    $this->addError('phone', __('User not found'));
                    RateLimiter::hit($throttleKey);
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
        return view('livewire.login-page')
            ->layout('components.layouts.app');
    }
}