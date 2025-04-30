<x-slot name="title">{{ __('profile.profile') }}</x-slot>

<section class="w-full bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-950 dark:to-neutral-900 py-12 px-4 sm:px-6 lg:px-8 mx-auto min-h-screen" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="w-full max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
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
                        {{ __('profile.back_to_home') }}
                    </a>
    
                    <!-- Sign Out Button -->
                    <form method="POST" action="{{ route('logout', ['locale' => app()->getLocale()]) }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                            </svg>
                            {{ __('profile.sign_out') }}
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
                    {{ __('profile.profile_settings') }}
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
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ __('profile.full_name') }}</label>
                            <input wire:model="name" id="name" type="text" required
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-neutral-800 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-neutral-800 dark:text-white">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ __('profile.email_address') }}</label>
                            <input wire:model="email" id="email" type="email" required
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-neutral-800 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-neutral-800 dark:text-white">
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                {{ __('profile.update_profile') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bookmarked Products Card -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                    {{ __('profile.bookmarked_products') }}
                </h3>
            
                
                <div class="grid grid-cols-1 gap-3">
                    @foreach ($bookmarkedProducts as $product)
                        <a href="{{ route('product.show', ['locale' => app()->getLocale(), 'id' => $product->id]) }}" 
                           class="block group relative bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-xl shadow-sm hover:shadow-md transition-shadow p-4 flex items-center {{ app()->getLocale() === 'ar' ? 'text-right' : '' }}">

                            <div class="flex-shrink-0 mr-4 {{ app()->getLocale() === 'ar' ? 'ml-4 mr-0' : '' }}">
                                <img src="{{ Storage::disk('s3')->url('products/' . $product->id . '/' . $product->id . '.png') }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-12 h-12 object-contain rounded-lg">
                            </div>
    
                            <div class="flex-grow">
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                                    {{ $product->account->name }}
                                </p>
                            </div>
                            
                    
                            <div class="flex-shrink-0 text-gray-400 group-hover:text-blue-600 transition-colors {{ app()->getLocale() === 'ar' ? 'mr-auto rotate-180' : 'ml-auto' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            

                @if($bookmarkedProducts->isEmpty())
                    <div class="bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-xl p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        <h3 class="mt-3 text-sm font-medium text-gray-900 dark:text-white">{{ __('profile.no_bookmarks_yet') }}</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 mb-4">{{ __('profile.bookmark_prompt') }}</p>
                        <a href="{{ route('products', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700">
                            {{ __('profile.browse_products') }}
                        </a>
                    </div>
                @endif
            </div>
            <div class="mt-8">
                @livewire('account-subscription')
            </div>
<div class="mt-8 space-y-6"> 
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
        {{ __('profile.your_reviews') }}
    </h3>

    @if($userReviews->isNotEmpty())
        <div class="space-y-4"> 
            @foreach ($userReviews as $review)
                <div class="bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-xl shadow-sm p-4 mb-4 last:mb-0"> 
                    <div class="flex items-start justify-between gap-4"> 
                        <div class="flex items-start gap-4 flex-1 min-w-0"> 
                            <div class="flex-shrink-0">
                                <img src="{{ Storage::disk('s3')->url('products/' . $review->product->id . '/' . $review->product->id . '.png') }}" 
                                     alt="{{ $review->product->name }}" 
                                     class="w-12 h-12 object-contain rounded-lg">
                            </div>
                            <div class="min-w-0"> 
                                <h4 class="font-medium text-gray-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }} truncate"> 
                                    {{ $review->product->name }}
                                </h4>
                                <div class="flex items-center mt-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-neutral-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }} break-words"> 
                                    {{ $review->comment }}
                                </p>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $review->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <button wire:click="deleteReview({{ $review->id }})" 
                                wire:confirm="{{ __('Are you sure you want to delete this review?') }}"
                                class="flex-shrink-0 text-red-500 hover:text-red-700 dark:hover:text-red-400 ml-2"> 
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-xl p-6 text-center mt-4"> 
        </div>
    @endif
</div>
        </div>
    </div>
</section>