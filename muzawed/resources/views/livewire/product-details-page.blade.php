<section class="min-h-screen bg-gradient-to-br from-blue-100 via-cyan-100 to-white dark:from-gray-950 dark:via-neutral-900 dark:to-black py-12 px-4 sm:px-6 lg:px-8 mx-auto" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-4xl mx-auto">
        <!-- Back Link -->
        <a href="{{ route('products', ['locale' => app()->getLocale()]) }}" class="group inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mb-8 transition-colors duration-200">
            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ __('saasproducts.back_to_products') }}
        </a>

        <!-- Hero Header -->
        <div class="relative bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-xl p-8 text-white dark:from-blue-700 dark:to-indigo-700 mb-12">
            <div class="flex items-center gap-4">
                <img src="{{ Storage::disk('s3')->url('products/' . $product->id . '/' . $product->id . '.png') }}" alt="Temporary Product Logo" class="h-16 w-32 object-contain">
                <div>
                    <h1 class="text-4xl font-bold tracking-tight {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                        {{ $product->name }}
                    </h1>
                    @if ($product->featured)
                        <span class="bg-gradient-to-r from-purple-600 to-indigo-900 text-transparent bg-clip-text dark:from-purple-600 dark:to-indigo-900">
                            {{ __('saasproducts.featured') }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="mt-4 flex flex-wrap gap-4">
                <span class="text-sm font-medium text-blue-100">
                    {{ __('saasproducts.by') }} {{ $product->account->name }}
                </span>
                <span class="text-sm font-medium text-green-200">
                    {{ app()->getLocale() === 'ar' ? $product->category->name_ar : $product->category->name_en }}
                </span>
            </div>
            <div class="absolute top-4 {{ app()->getLocale() === 'ar' ? 'left-4' : 'right-4' }}">
                @livewire('bookmark-toggle', ['productId' => $product->id])
            </div>
        </div>
        <!-- Additional product details content -->
        <!-- Main Content -->
        <div class="hs-card bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl shadow-md p-6">
            <!-- Overview -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                        {{ __('saasproducts.pricing_model') }}
                    </h2>
                    <p class="mt-2 text-gray-600 dark:text-neutral-400">
                        {{ ucfirst(str_replace('-', ' ', $product->pricing_model)) }}
                    </p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                        {{ __('saasproducts.version') }}
                    </h2>
                    <p class="mt-2 text-gray-600 dark:text-neutral-400">
                        {{ $product->version ?? __('saasproducts.not_specified') }}
                    </p>
                </div>
            </div>

            <!-- Rating -->
            @if ($product->average_rating > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                        {{ __('saasproducts.rating') }}
                    </h2>
                    <div class="flex items-center mt-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-6 h-6 {{ $product->average_rating >= $i ? 'text-yellow-400' : 'text-gray-300 dark:text-neutral-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                        <span class="ml-3 text-sm text-gray-600 dark:text-neutral-400">
                            {{ number_format($product->average_rating, 1) }} ({{ $product->review_count }} {{ __('saasproducts.reviews') }})
                        </span>
                    </div>
                </div>
            @endif

            <!-- Descriptions -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                    {{ __('saasproducts.description') }}
                </h2>
                <p class="mt-2 text-gray-600 dark:text-neutral-400">
                    @if (app()->getLocale() === 'ar')
                        {{ $product->description_ar ?? __('saasproducts.no_description') }}
                    @else
                        {{ $product->description_en ?? __('saasproducts.no_description') }}
                    @endif
                </p>
            </div>

            @if (app()->getLocale() === 'ar' ? $product->detailed_description_ar : $product->detailed_description_en)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                        {{ __('saasproducts.detailed_description') }}
                    </h2>
                    <p class="mt-2 text-gray-600 dark:text-neutral-400 whitespace-pre-line">
                        @if (app()->getLocale() === 'ar')
                            {{ $product->detailed_description_ar }}
                        @else
                            {{ $product->detailed_description_en }}
                        @endif
                    </p>
                </div>
            @endif

            <!-- Features Accordion -->
<!-- Key Features -->
@if ($product->key_features_en || $product->key_features_ar)
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200 mb-4">
            {{ __('saasproducts.key_features') }}
        </h2>
        <div class="hs-accordion-group">
            @foreach ((app()->getLocale() === 'ar' ? ($product->key_features_ar ?? []) : ($product->key_features_en ?? [])) as $index => $feature)
                <div class="hs-accordion bg-gray-50 dark:bg-neutral-900 rounded-lg mb-2" id="feature-{{ $index }}">
                    <button class="hs-accordion-toggle inline-flex items-center justify-between w-full p-4 text-left text-gray-800 dark:text-neutral-200 font-medium hover:bg-gray-100 dark:hover:bg-neutral-800 rounded-lg transition" type="button">
                        <span>
                            {{ $feature['product']['name'] ?? __('saasproducts.unknown_feature') }}
                        </span>
                        <svg class="hs-accordion-active:hidden w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        <svg class="hs-accordion-active:block hidden w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                        </svg>
                    </button>
                    <div id="feature-content-{{ $index }}" class="hs-accordion-content hidden p-4 text-gray-600 dark:text-neutral-400">
                        {{ app()->getLocale() === 'ar' ? ($feature['product']['description_ar'] ?? $feature['product']['description_en'] ?? __('saasproducts.no_description_available')) : ($feature['product']['description_en'] ?? __('saasproducts.no_description_available')) }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

            <!-- Tags -->
            @if ($product->tags->isNotEmpty())
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                        {{ __('saasproducts.tags') }}
                    </h2>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($product->tags as $tag)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-white">
                                {{ app()->getLocale() === 'ar' ? $tag->name_ar : $tag->name_en }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Support Info -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                        {{ __('saasproducts.support_email') }}
                    </h2>
                    <p class="mt-2 text-gray-600 dark:text-neutral-400">
                        @if ($product->support_email)
                            <a href="mailto:{{ $product->support_email }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                {{ $product->support_email }}
                            </a>
                        @else
                            {{ __('saasproducts.not_provided') }}
                        @endif
                    </p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                        {{ __('saasproducts.support_hours') }}
                    </h2>
                    <p class="mt-2 text-gray-600 dark:text-neutral-400">
                        {{ $product->support_hours ?? __('saasproducts.not_specified') }}
                    </p>
                </div>
            </div>

            <!-- Links -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                        {{ __('saasproducts.documentation') }}
                    </h2>
                    <p class="mt-2 text-gray-600 dark:text-neutral-400">
                        @if ($product->documentation_url)
                            <a href="{{ $product->documentation_url }}" target="_blank" class="text-blue-600 hover:underline dark:text-blue-400">
                                {{ __('saasproducts.view_documentation') }}
                            </a>
                        @else
                            {{ __('saasproducts.not_available') }}
                        @endif
                    </p>
                </div>
            </div>

            <!-- Action Button -->
            <div class="mt-8">
                <a
                    href="{{ $product->product_link ?? '#' }}"
                    class="hs-button inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 dark:from-blue-500 dark:to-indigo-500 dark:hover:from-blue-600 dark:hover:to-indigo-600 transition-all duration-200 {{ !$product->product_link ? 'opacity-50 cursor-not-allowed' : '' }}"
                >
                    {{ __('saasproducts.explore_product') }}
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>