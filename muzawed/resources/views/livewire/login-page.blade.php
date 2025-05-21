<x-slot name="title">{{ __('Login') }}</x-slot>

<section class="w-full bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-950 dark:to-neutral-900 py-12 px-4 sm:px-6 lg:px-8 mx-auto min-h-screen flex flex-col sm:justify-center items-center" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="w-full sm:max-w-md bg-white dark:bg-neutral-900 rounded-2xl p-6 sm:p-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }} mb-6 text-center">
            {{ __('login.sign_in_to') }} <span class="bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text">{{ __('login.muzawed') }}</span>
        </h2>

        <div class="grid gap-y-4">
            <div>
                <label for="phone" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ __('login.phone_number') }}</label>
                <div class="relative">
                    <input
                        wire:model="phone"
                        type="text"
                        id="phone"
                        name="phone"
                        class="py-2.5 sm:py-3 px-4 block w-full border border-gray-300 dark:border-neutral-800 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}"
                        placeholder="{{ __('+966XXXXXXXXX') }}"
                        required
                        aria-describedby="phone-error"
                        autocomplete="tel"
                    />
                    @error('phone')
                        <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'start-0 ps-3' : 'end-0 pe-3' }} flex items-center pointer-events-none">
                            <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                            </svg>
                        </div>
                    @enderror
                </div>
                @error('phone')
                    <p class="text-xs text-red-600 mt-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" id="phone-error">{{ $message }}</p>
                @else
                    <p class="hidden text-xs text-red-600 mt-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" id="phone-error">{{ __('login.valid_num') }}</p>
                @endif
            </div>

            @if($showOtpInput)
                <div>
                    <label for="otp" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ __('login.otp') }}</label>
                    <div class="relative">
                        <input
                            wire:model="otp"
                            type="text"
                            id="otp"
                            name="otp"
                            class="py-2.5 sm:py-3 px-4 block w-full border border-gray-300 dark:border-neutral-800 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}"
                            placeholder="{{ __('login.enter_otp') }}"
                            required
                            aria-describedby="otp-error"
                            autocomplete="one-time-code"
                        />
                        @error('otp')
                            <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'start-0 ps-3' : 'end-0 pe-3' }} flex items-center pointer-events-none">
                                <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                </svg>
                            </div>
                        @enderror
                    </div>
                    @error('otp')
                        <p class="text-xs text-red-600 mt-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" id="otp-error">{{ $message }}</p>
                    @else
                        <p class="hidden text-xs text-red-600 mt-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" id="otp-error">{{ __('login.enter_otp') }}</p>
                    @endif
                </div>
            @endif

            @if(!$showOtpInput)
                <button
                    wire:click="sendOtp"
                    type="button"
                    class="mt-4 w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-lg border border-transparent bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}"
                >
                    {{ __('login.send_otp') }}
                </button>
            @else
                <button
                    wire:click="verifyOtp"
                    type="button"
                    class="mt-4 w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-lg border border-transparent bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}"
                >
                    {{ __('login.verify_otp') }}
                </button>
            @endif
        </div>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600 dark:text-gray-400 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                {{ __('login.have_account') }}
                <a href="{{ route('register', ['locale' => app()->getLocale()]) }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                    {{ __('login.sign_up') }}
                </a>
            </p>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('livewire:dispatch', event => {
            if (event.detail.event === 'otp-sent') {
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 {{ app()->getLocale() === "ar" ? "left-4" : "right-4" }} bg-green-500 text-white p-4 rounded-lg';
                toast.textContent = event.detail.data.message;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }
        });
    </script>
@endpush