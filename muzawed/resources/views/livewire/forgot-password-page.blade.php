<x-slot name="title">{{ __('Reset Password') }}</x-slot>

<section class="w-full bg-gradient-to-br from-blue-200 to-cyan-200 dark:from-gray-950 dark:to-neutral-900 py-12 px-4 sm:px-6 lg:px-8 mx-auto min-h-screen flex flex-col sm:justify-center items-center" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="w-full sm:max-w-md bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-2xl shadow-xl p-6 sm:p-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }} mb-6 text-center">
            {{ __('Reset Your') }} <span class="bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text">{{ __('Muzawed') }}</span> {{ __('Password') }}
        </h2>

        @if ($status)
            <div class="rounded-md bg-green-50 dark:bg-green-900/50 p-4 mb-6">
                <div class="flex {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <div class="{{ app()->getLocale() === 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                        <p class="text-sm text-green-800 dark:text-green-200 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ $status }}</p>
                    </div>
                </div>
            </div>
        @endif

        <form wire:submit.prevent="resetPassword">
            <div class="grid gap-y-4">
                @if ($errors->any())
                    <div class="rounded-md bg-red-50 dark:bg-red-900/50 p-4">
                        <div class="flex {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 1 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                            </svg>
                            <div class="{{ app()->getLocale() === 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ __('Whoops! Something went wrong.') }}</h3>
                                <ul class="mt-2 list-disc {{ app()->getLocale() === 'ar' ? 'list-inside' : 'list-inside' }} text-sm text-red-600 dark:text-red-300">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div>
                    <label for="email" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ __('Email address') }}</label>
                    <div class="relative">
                        <input
                            wire:model="email"
                            type="email"
                            id="email"
                            name="email"
                            class="py-3 sm:py-4 px-4 block w-full border border-gray-300 dark:border-neutral-800 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}"
                            required
                            aria-describedby="email-error"
                            autocomplete="email"
                            {{ $otpSent ? 'disabled' : '' }}
                        />
                        @error('email')
                            <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'start-0 ps-3' : 'end-0 pe-3' }} flex items-center pointer-events-none">
                                <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 1 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                </svg>
                            </div>
                        @enderror
                    </div>
                    @error('email')
                        <p class="text-xs text-red-600 mt-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" id="email-error">{{ $message }}</p>
                    @else
                        <p class="hidden text-xs text-red-600 mt-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" id="email-error">{{ __('Please include a valid email address') }}</p>
                    @endif
                </div>

                <button
                    type="button"
                    wire:click="sendOtp"
                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-lg border border-transparent bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}"
                    {{ $otpSent ? 'disabled' : '' }}
                >
                    {{ __('Send OTP Email') }}
                </button>

                <div>
                    <label for="otp" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ __('OTP') }}</label>
                    <div class="relative">
                        <input
                            wire:model="otp"
                            type="text"
                            id="otp"
                            name="otp"
                            class="py-3 sm:py-4 px-4 block w-full border border-gray-300 dark:border-neutral-800 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}"
                            required
                            aria-describedby="otp-error"
                            {{ !$otpSent ? 'disabled' : '' }}
                        />
                        @error('otp')
                            <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'start-0 ps-3' : 'end-0 pe-3' }} flex items-center pointer-events-none">
                                <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 1 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                </svg>
                            </div>
                        @enderror
                    </div>
                    @error('otp')
                        <p class="text-xs text-red-600 mt-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" id="otp-error">{{ $message }}</p>
                    @else
                        <p class="hidden text-xs text-red-600 mt-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" id="otp-error">{{ __('Enter the 6-digit OTP') }}</p>
                    @endif
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ __('New Password') }}</label>
                    <div class="relative">
                        <input
                            wire:model="password"
                            type="password"
                            id="password"
                            name="password"
                            class="py-3 sm:py-4 px-4 block w-full border border-gray-300 dark:border-neutral-800 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}"
                            required
                            aria-describedby="password-error"
                            autocomplete="new-password"
                            {{ !$otpSent ? 'disabled' : '' }}
                        />
                        @error('password')
                            <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'start-0 ps-3' : 'end-0 pe-3' }} flex items-center pointer-events-none">
                                <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 1 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                </svg>
                            </div>
                        @enderror
                    </div>
                    @error('password')
                        <p class="text-xs text-red-600 mt-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" id="password-error">{{ $message }}</p>
                    @else
                        <p class="hidden text-xs text-red-600 mt-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" id="password-error">{{ __('8+ characters required') }}</p>
                    @endif
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ __('Confirm New Password') }}</label>
                    <div class="relative">
                        <input
                            wire:model="password_confirmation"
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="py-3 sm:py-4 px-4 block w-full border border-gray-300 dark:border-neutral-800 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}"
                            required
                            aria-describedby="password_confirmation-error"
                            autocomplete="new-password"
                            {{ !$otpSent ? 'disabled' : '' }}
                        />
                        @error('password_confirmation')
                            <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'start-0 ps-3' : 'end-0 pe-3' }} flex items-center pointer-events-none">
                                <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 1 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                </svg>
                            </div>
                        @enderror
                    </div>
                    @error('password_confirmation')
                        <p class="text-xs text-red-600 mt-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" id="password_confirmation-error">{{ $message }}</p>
                    @else
                        <p class="hidden text-xs text-red-600 mt-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" id="password_confirmation-error">{{ __('Passwords must match') }}</p>
                    @endif
                </div>

                <button
                    type="submit"
                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-lg border border-transparent bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}"
                    {{ !$otpSent ? 'disabled' : '' }}
                >
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600 dark:text-gray-400 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                {{ __('Remember your password?') }}
                <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                    {{ __('Sign in') }}
                </a>
            </p>
        </div>
    </div>
</section>