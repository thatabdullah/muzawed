@component('mail::message')
# {{ __('Muzawed Password Reset') }}

{{ __('Your OTP for resetting your password is:') }}

@component('mail::panel')
{{ $otp }}
@endcomponent

{{ __('This OTP is valid for 10 minutes. Enter it on the password reset page to set a new password.') }}

{{ __('If you did not request a password reset, please ignore this email.') }}

@component('mail::button', ['url' => route('password.request', ['locale' => app()->getLocale()])])
{{ __('Reset Password') }}
@endcomponent

{{ __('Thanks,') }}<br>
{{ config('app.name') }}
@endcomponent