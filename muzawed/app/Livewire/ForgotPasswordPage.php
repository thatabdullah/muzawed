<?php

namespace App\Livewire;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ForgotPasswordPage extends Component
{
    public $email;
    public $otp;
    public $password;
    public $password_confirmation;
    public $status;
    public $otpSent = false;

    protected $rules = [
        'email' => 'required|email|exists:users,email',
        'otp' => 'required|digits:6',
        'password' => 'required|min:8|confirmed',
    ];

    public function sendOtp()
    {
        $this->validateOnly('email');

        // Rate limiting
        $throttleKey = Str::lower($this->email) . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $this->addError('email', __('Too many attempts. Please try again in :seconds seconds.', [
                'seconds' => RateLimiter::availableIn($throttleKey),
            ]));
            return;
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $this->email],
            ['token' => Hash::make($otp), 'created_at' => now()]
        );

        // Send OTP email
        try {
            Mail::to($this->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            RateLimiter::hit($throttleKey);
            $this->addError('email', __('Failed to send OTP. Please try again.'));
            return;
        }

        RateLimiter::clear($throttleKey);
        $this->otpSent = true;
        $this->status = __('OTP sent to your email.');
    }

    public function resetPassword()
    {
        $this->validate();

        $throttleKey = Str::lower($this->email) . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $this->addError('email', __('Too many attempts. Please try again in :seconds seconds.', [
                'seconds' => RateLimiter::availableIn($throttleKey),
            ]));
            return;
        }

        // Verify OTP
        $reset = DB::table('password_resets')
            ->where('email', $this->email)
            ->where('created_at', '>=', now()->subMinutes(10))
            ->first();

        if (!$reset || !Hash::check($this->otp, $reset->token)) {
            RateLimiter::hit($throttleKey);
            $this->addError('otp', __('Invalid or expired OTP.'));
            return;
        }

        // Update password
        $user = User::where('email', $this->email)->first();
        $user->update(['password' => Hash::make($this->password)]);

        // Clear OTP
        DB::table('password_resets')->where('email', $this->email)->delete();

        RateLimiter::clear($throttleKey);
        $this->status = __('Password reset successfully. Please sign in.');
        $this->reset(['email', 'otp', 'password', 'password_confirmation', 'otpSent']);


        return redirect()->route('login', ['locale' => app()->getLocale()]);
    }

    public function render()
    {
        return view('livewire.forgot-password-page');
    }
}