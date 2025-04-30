<section class="py-16 px-4 sm:px-6 lg:px-8 mx-auto" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-4xl mx-auto">
        <!-- Ratings Summary -->
        <div class="mb-12 bg-white/90 dark:bg-neutral-900/90 backdrop-blur-md border border-gray-200/30 dark:border-neutral-700/30 rounded-3xl shadow-lg p-8 transition-all duration-300 hover:shadow-xl">
            <h3 class="text-2xl font-bold text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text dark:from-blue-600 dark:to-indigo-600 mb-6">
                {{ __('saasproducts.customer_reviews') }}
            </h3>
            <div class="flex flex-col md:flex-row items-center gap-8">
                <!-- Average Rating -->
                <div class="flex-1">
                    <div class="flex flex-col items-center">
                        <h2 class="text-5xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text dark:from-blue-600 dark:to-indigo-600 mb-3">
                            {{ number_format($averageRating, 2) }}
                        </h2>
                        <div class="flex {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : 'flex-row' }} gap-1 mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-7 h-7 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300 dark:text-neutral-600' }} transition-transform duration-300 hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">{{ $totalReviews }} {{ __('saasproducts.ratings') }}</p>
                    </div>
                </div>
                <!-- Star Distribution -->
                <div class="flex-1">
                    <div class="space-y-2">
                        @for ($i = 5; $i >= 1; $i--)
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-medium text-gray-600 dark:text-neutral-400 w-3">{{ $i }}</span>
                                <div class="flex-1 bg-gray-200/50 dark:bg-neutral-700/50 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-yellow-400 to-amber-500 h-1.5 rounded-full transition-all duration-700 ease-out" style="width: {{ $ratingDistribution[$i] ?? 0 }}%"></div>
                                </div>
                                <span class="text-xs font-medium text-gray-600 dark:text-neutral-400">{{ $ratingDistribution[$i] ?? 0 }}%</span>
                            </div>
                        @endfor
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                    <div class="flex justify-center gap-2">
                        @auth
                            <button onclick="document.getElementById('review-form').scrollIntoView({ behavior: 'smooth' })" 
                                    class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 dark:from-blue-500 dark:to-indigo-500 dark:hover:from-blue-600 dark:hover:to-indigo-600 transition-all duration-300 shadow-md hover:shadow-lg disabled:opacity-50 whitespace-nowrap">
                                {{ __('saasproducts.write_review') }}
                            </button>
                        @else
                            <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" 
                               class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 dark:from-blue-500 dark:to-indigo-500 dark:hover:from-blue-600 dark:hover:to-indigo-600 transition-all duration-300 shadow-md hover:shadow-lg disabled:opacity-50 whitespace-nowrap">
                                {{ __('saasproducts.sign_in_to_review') }}
                            </a>
                        @endauth
                        <a href="#reviews-list" 
                           class="px-6 py-2 bg-white dark:bg-neutral-900 text-gray-800 dark:text-white border border-gray-300 dark:border-neutral-800 font-medium rounded-lg hover:bg-gradient-to-r hover:from-blue-600 hover:to-indigo-600 hover:text-white transition-all duration-300 shadow-md hover:shadow-lg disabled:opacity-50 whitespace-nowrap">
                            {{ __('saasproducts.see_all_reviews') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Review Form -->
        @auth
            <div id="review-form" class="mt-5 mb-12 bg-white/90 dark:bg-neutral-900/90 backdrop-blur-md border border-gray-200/30 dark:border-neutral-700/30 rounded-3xl shadow-lg p-8 transition-all duration-300 hover:shadow-xl">
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-neutral-200 mb-6">{{ __('saasproducts.write_review') }}</h3>
                <div class="flex items-center gap-2 mb-6">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" wire:click="setRating({{ $i }})" wire:mouseover="setHoverRating({{ $i }})" wire:mouseout="setHoverRating(0)" class="focus:outline-none" title="{{ $i }} {{ __('saasproducts.star') }}">
                            <svg class="w-7 h-7 {{ $i <= ($hoverRating ?: $rating) ? 'text-yellow-400' : 'text-gray-300 dark:text-neutral-600' }} transition-transform duration-300 hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </button>
                    @endfor
                </div>
                <textarea wire:model="comment" rows="4" class="w-full px-4 py-3 border border-gray-200/50 dark:border-neutral-700/50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white/50 dark:bg-neutral-900/50 text-gray-800 dark:text-neutral-200 placeholder-gray-400 dark:placeholder-neutral-400 transition-all duration-300" placeholder="{{ __('saasproducts.share_thoughts') }}"></textarea>
                <button wire:click="submitReview" wire:loading.attr="disabled" class="mt-4 px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 dark:from-blue-500 dark:to-indigo-500 dark:hover:from-blue-600 dark:hover:to-indigo-600 transition-all duration-300 shadow-md hover:shadow-lg disabled:opacity-50" :disabled="!$rating">
                    {{ __('saasproducts.submit_review') }}
                </button>
            </div>
        @endif

        <!-- Reviews Carousel -->
        <div id="reviews-list" class="mb-12">
            <h4 class="text-2xl font-semibold text-gray-800 dark:text-neutral-200 mb-6">{{ __('saasproducts.all_reviews') }}</h4>
            <div class="relative">
                <div id="reviews-carousel" class="flex overflow-x-auto snap-x snap-mandatory gap-6 pb-4 scroll-smooth overscroll-contain scrollbar-width-thin scrollbar-color-gray-300-gray-100 [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-thumb]:rounded-full dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                    @forelse ($reviews as $index => $review)
                        <div class="snap-start flex-none w-full sm:w-80 bg-white/90 dark:bg-neutral-900/90 backdrop-blur-md border border-gray-200/30 dark:border-neutral-700/30 rounded-3xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center text-white font-medium">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-800 dark:text-neutral-200">{{ $review->user->name }}</span>
                                        <p class="text-xs text-gray-600 dark:text-neutral-400">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-1 text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-neutral-600' }} transition-transform duration-300 hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-neutral-400 text-sm leading-relaxed line-clamp-4">
                                "{{ $review->comment }}"
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-600 dark:text-neutral-400 bg-white/90 dark:bg-neutral-900/90 backdrop-blur-md border border-gray-200/30 dark:border-neutral-700/30 rounded-3xl shadow-lg">
                            {{ __('saasproducts.no_reviews_yet') }}
                        </div>
                    @endforelse
                </div>
                <!-- Progress Dots -->
                @if($reviews->count() > 1)
                    <div class="flex justify-center gap-2 mt-4">
                        @foreach ($reviews as $index => $review)
                            <div class="w-2 h-2 rounded-full {{ $index === 0 ? 'bg-blue-600' : 'bg-gray-300 dark:bg-neutral-600' }} transition-all duration-300 dot" data-index="{{ $index }}"></div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</section>