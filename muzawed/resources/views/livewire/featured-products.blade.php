<section class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <h2 class="text-2xl font-bold text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text dark:from-blue-400 dark:to-indigo-200">{{ __('homepage.featured_products') }}</h2>
    @if ($products->isEmpty())
        <p class="mt-6 text-center text-gray-600 dark:text-neutral-500">{{ __('homepage.no_featured_products') }}</p>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @foreach ($products as $product)
                <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div class="h-32 flex flex-col justify-center items-center bg-blue-600 rounded-t-xl">
                        <img src="https://placehold.co/64x32/2563eb/1e40af/png?text=Logo" alt="Temporary Product Logo" class="h-8 w-16 object-contain">
                    </div>
                    <div class="p-4 md:p-6">
                        <span class="block mb-1 text-xs font-semibold uppercase text-blue-600 dark:text-blue-500">{{ $product->account->name }}</span>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">{{ $product->name }}</h3>
                        <p class="mt-3 text-gray-500 dark:text-neutral-500">{{ app()->getLocale() === 'ar' ? $product->description_ar : $product->description_en }}</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($product->tags as $tag)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-light bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    {{ app()->getLocale() === 'ar' ? $tag->name_ar : $tag->name_en }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200 dark:border-neutral-700 dark:divide-neutral-700">
                        <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-b-xl bg-white text-gray-800 shadow-2xs hover:bg-blue-600 hover:text-white disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-blue-600 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ url(app()->getLocale() . '/products') }}">{{ __('homepage.explore') }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>