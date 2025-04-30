<x-slot name="title">{{ __('Login') }}</x-slot>

<section class="w-full bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-950 dark:to-neutral-900 py-12 px-4 sm:px-6 lg:px-8 mx-auto min-h-screen flex flex-col sm:justify-center items-center" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="w-full sm:max-w-md bg-white dark:bg-neutral-900 rounded-2xl p-6 sm:p-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }} mb-6 text-center">
            {{ __('Sign in to') }} <span class="bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text">{{ __('Muzawed') }}</span>
        </h2>

        <form wire:submit.prevent="login">
            <div class="grid gap-y-4">
                <div>
                    <label for="email" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ __('Email address') }}</label>
                    <div class="relative">
                        <input
                            wire:model="email"
                            type="email"
                            id="email"
                            name="email"
                            class="py-2.5 sm:py-3 px-4 block w-full border border-gray-300 dark:border-neutral-800 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}"
                            required
                            aria-describedby="email-error"
                            autocomplete="email"
                        />
                        @error('email')
                            <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'start-0 ps-3' : 'end-0 pe-3' }} flex items-center pointer-events-none">
                                <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                </svg>
                            </div>
                        @enderror
                    </div>
                    @error('email')
                        <p class="text-xs text-red-600 mt-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" id="email-error">{{ $message }}</p>
                    @else
                        <p class="hidden text-xs text-red-600 mt-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" id="email-error">{{ __('Please include a valid email address so we can get back to you') }}</p>
                    @endif
                </div>

                <div>
                    <div class="flex flex-wrap {{ app()->getLocale() === 'ar' ? 'justify-between flex-row-reverse' : 'justify-between' }} items-center gap-2">
                        <label for="password" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ __('Password') }}</label>
                        <a class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500 dark:hover:text-blue-400 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" href="{{ route('password.request', ['locale' => app()->getLocale()]) }}">{{ __('Forgot password?') }}</a>
                    </div>
                    <div class="relative">
                        <input
                            wire:model="password"
                            type="password"
                            id="password"
                            name="password"
                            class="py-2.5 sm:py-3 px-4 block w-full border border-gray-300 dark:border-neutral-800 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}"
                            required
                            aria-describedby="password-error"
                            autocomplete="current-password"
                        />
                        @error('password')
                            <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'start-0 ps-3' : 'end-0 pe-3' }} flex items-center pointer-events-none">
                                <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
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

                <div class="flex items-center mt-2">
                    <div class="flex">
                        <input
                            wire:model="remember"
                            id="remember-me"
                            name="remember-me"
                            type="checkbox"
                            class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                        />
                    </div>
                    <div class="{{ app()->getLocale() === 'ar' ? 'me-3' : 'ms-3' }}">
                        <label for="remember-me" class="text-sm font-bold text-gray-700 dark:text-gray-300 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ __('Remember me') }}</label>
                    </div>
                </div>

                <button
                    type="submit"
                    class="mt-4 w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-lg border border-transparent bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}"
                >
                    {{ __('Sign in') }}
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600 dark:text-gray-400 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                {{ __('Don’t have an account?') }}
                <a href="{{ route('register', ['locale' => app()->getLocale()]) }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                    {{ __('Sign up') }}
                </a>
            </p>
        </div>
    </div>
</section>