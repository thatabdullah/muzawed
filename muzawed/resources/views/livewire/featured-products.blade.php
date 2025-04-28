<section class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <h2 class="text-2xl font-bold text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text dark:from-blue-400 dark:to-indigo-200">{{ __('homepage.featured_products') }}</h2>
    @if ($products->isEmpty())
        <p class="mt-6 text-center text-gray-600 dark:text-neutral-500">{{ __('homepage.no_featured_products') }}</p>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @foreach ($products as $product)
                <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div class="h-32 flex flex-col justify-center items-center bg-blue-600 rounded-t-xl">
                        <img src="{{ Storage::disk('s3')->url('products/' . $product->id . '/' . $product->id . '.png') }}" alt="Temporary Product Logo" class="max-h-16 max-w-32 object-contain">
                    </div>
                    <div class="p-4 md:p-6">
                        <span class="block mb-1 text-xs font-semibold uppercase text-blue-600 dark:text-blue-500">{{ $product->account->name }}</span>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">{{ $product->name }}</h3>
                        <span class="block mb-1 text-xs font-semibold uppercase text-green-600 dark:text-green-600">
                            {{ app()->getLocale() === 'ar' ? $product->category->name_ar : $product->category->name_en }}
                        </span>
                        <p class="mt-3 text-gray-500 dark:text-neutral-500">{{ app()->getLocale() === 'ar' ? $product->description_ar : $product->description_en }}</p>
                        <div class="mt-3 flex items-center gap-x-1">
                            <svg
                                class="w-5 h-5 text-yellow-400"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-sm text-gray-600 dark:text-neutral-400">
                                {{ number_format($product->average_rating, 1) }}
                            </span>
                        </div>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($product->tags as $tag)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-light bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    {{ app()->getLocale() === 'ar' ? $tag->name_ar : $tag->name_en }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200 dark:border-neutral-700 dark:divide-neutral-700">
                        <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-b-xl bg-white text-gray-800 shadow-2xs hover:bg-blue-600 hover:text-white disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-blue-600 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('product.show', ['locale' => app()->getLocale(), 'id' => $product->id]) }}">{{ __('homepage.explore') }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>