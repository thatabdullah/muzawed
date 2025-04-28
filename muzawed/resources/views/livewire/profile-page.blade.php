<x-slot name="title">{{ __('Profile') }}</x-slot>

<section class="w-full bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-950 dark:to-neutral-900 py-12 px-4 sm:px-6 lg:px-8 mx-auto min-h-screen" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="w-full max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-2xl shadow-sm p-6 sticky top-24">
                <div class="text-center mb-6">
                    <div class="mx-auto w-24 h-24 rounded-full bg-gray-100 dark:bg-neutral-800 mb-4 overflow-hidden">
                        <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=random' }}" 
                             alt="{{ __('Profile Picture') }}" 
                             class="w-full h-full object-cover">
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                        {{ auth()->user()->name }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ auth()->user()->email }}</p>
                </div>
    
                <div class="space-y-4">
                    <!-- Back to Home Button -->
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-neutral-800 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        {{ __('Back to Home') }}
                    </a>
    
                    <!-- Sign Out Button -->
                    <form method="POST" action="{{ route('logout', ['locale' => app()->getLocale()]) }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Sign out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column - Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Update Card -->
            <div class="bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                    {{ __('Profile Settings') }}
                </h3>

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

                <form wire:submit.prevent="updateProfile">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ __('Full Name') }}</label>
                            <input wire:model="name" id="name" type="text" required
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-neutral-800 dark:text-white">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ __('Email Address') }}</label>
                            <input wire:model="email" id="email" type="email" required
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-neutral-800 dark:text-white">
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                {{ __('Update Profile') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bookmarked Products Card -->
            <div class="space-y-4">
                <!-- Section Header -->
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                    {{ __('Bookmarked Products') }}
                </h3>
            
                <!-- Bookmarked Products List -->
                <div class="grid grid-cols-1 gap-3">
                    @foreach ($bookmarkedProducts as $product)
                        <a href="{{ route('product.show', ['locale' => app()->getLocale(), 'id' => $product->id]) }}" 
                           class="block group relative bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-xl shadow-sm hover:shadow-md transition-shadow p-4 flex items-center {{ app()->getLocale() === 'ar' ? 'text-right' : '' }}">
                            <!-- Product Logo -->
                            <div class="flex-shrink-0 mr-4 {{ app()->getLocale() === 'ar' ? 'ml-4 mr-0' : '' }}">
                                <img src="{{ Storage::disk('s3')->url('products/' . $product->id . '/' . $product->id . '.png') }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-12 h-12 object-contain rounded-lg">
                            </div>
                            
                            <!-- Product Name and Account -->
                            <div class="flex-grow">
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                                    {{ $product->account->name }}
                                </p>
                            </div>
                            
                            <!-- Arrow icon -->
                            <div class="flex-shrink-0 text-gray-400 group-hover:text-blue-600 transition-colors {{ app()->getLocale() === 'ar' ? 'mr-auto rotate-180' : 'ml-auto' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            
                <!-- Empty State -->
                @if($bookmarkedProducts->isEmpty())
                    <div class="bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-xl p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        <h3 class="mt-3 text-sm font-medium text-gray-900 dark:text-white">{{ __('No bookmarks yet') }}</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 mb-4">{{ __('Save products to access them quickly here') }}</p>
                        <a href="{{ route('products', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700">
                            {{ __('Browse Products') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>