<x-slot name="title">{{ __('Register') }}</x-slot>

<section class="w-full bg-gradient-to-br from-blue-50 to-cyan-50 dark:bg-gradient-to-r dark:from-gray-950 dark:to-neutral-900 py-10 px-4 sm:px-6 lg:px-8 mx-auto min-h-screen flex flex-col sm:justify-center items-center" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="mb-6">
        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">
            
        </a>
    </div>

    <div class="w-full sm:max-w-md px-6 py-8 bg-white dark:bg-neutral-900 rounded-2xl">
        <div class="p-4 sm:p-7">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-center">
                {{ __('Create an account on') }} <span class="bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text">{{ __('Muzawed') }}</span>
            </h2>

            <form wire:submit.prevent="register">
                <div class="grid gap-y-6">

                    <div>
                        <label for="name" class="block text-sm font-bold mb-2 dark:text-white">{{ __('Name') }}</label>
                        <div class="relative">
                            <input wire:model="name" type="text" id="name" name="name" class="py-2.5 sm:py-3 px-4 block w-full border border-gray-300 dark:border-neutral-800 rounded-lg sm:text-sm disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-0 focus:border-transparent hover:border-transparent" required aria-describedby="name-error" autocomplete="name">
                            @error('name')
                                <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'start-0 ps-3' : 'end-0 pe-3' }} flex items-center pointer-events-none">
                                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('name')
                            <p class="text-xs text-red-600 mt-2" id="name-error">{{ $message }}</p>
                        @else
                            <p class="hidden text-xs text-red-600 mt-2" id="name-error">{{ __('Please enter your full name') }}</p>
                        @endif
                    </div>
                   
                    <div>
                        <label for="email" class="block text-sm font-bold mb-2 dark:text-white">{{ __('Email address') }}</label>
                        <div class="relative">
                            <input wire:model="email" type="email" id="email" name="email" class="py-2.5 sm:py-3 px-4 block w-full border border-gray-300 dark:border-neutral-800 rounded-lg sm:text-sm disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-0 focus:border-transparent hover:border-transparent" required aria-describedby="email-error" autocomplete="email">
                            @error('email')
                                <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'start-0 ps-3' : 'end-0 pe-3' }} flex items-center pointer-events-none">
                                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('email')
                            <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                        @else
                            <p class="hidden text-xs text-red-600 mt-2" id="email-error">{{ __('Please include a valid email address so we can get back to you') }}</p>
                        @endif
                    </div>
                  
                    <div>
                        <label for="password" class="block text-sm font-bold mb-2 dark:text-white">{{ __('Password') }}</label>
                        <div class="relative">
                            <input wire:model="password" type="password" id="password" name="password" class="py-2.5 sm:py-3 px-4 block w-full border border-gray-300 dark:border-neutral-800 rounded-lg sm:text-sm disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-0 focus:border-transparent hover:border-transparent" required aria-describedby="password-error" autocomplete="new-password">
                            @error('password')
                                <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'start-0 ps-3' : 'end-0 pe-3' }} flex items-center pointer-events-none">
                                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600 mt-2" id="password-error">{{ $message }}</p>
                        @else
                            <p class="hidden text-xs text-red-600 mt-2" id="password-error">{{ __('8+ characters required') }}</p>
                        @endif
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold mb-2 dark:text-white">{{ __('Confirm Password') }}</label>
                        <div class="relative">
                            <input wire:model="password_confirmation" type="password" id="password_confirmation" name="password_confirmation" class="py-2.5 sm:py-3 px-4 block w-full border border-gray-300 dark:border-neutral-800 rounded-lg sm:text-sm disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-0 focus:border-transparent hover:border-transparent" required aria-describedby="password_confirmation-error" autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'start-0 ps-3' : 'end-0 pe-3' }} flex items-center pointer-events-none">
                                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('password_confirmation')
                            <p class="text-xs text-red-600 mt-2" id="password_confirmation-error">{{ $message }}</p>
                        @else
                            <p class="hidden text-xs text-red-600 mt-2" id="password_confirmation-error">{{ __('Passwords do not match') }}</p>
                        @endif
                    </div>
                    

                    <button type="submit" class="mt-4 w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">{{ __('Sign up') }}</button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Already have an account?') }}
                    <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                        {{ __('Sign in') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>