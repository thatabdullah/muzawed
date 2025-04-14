<section class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <h2 class="text-2xl font-bold text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text dark:from-blue-600 dark:to-indigo-600">{{ __('footer.categories') }}</h2>
    @if ($categories->isEmpty())
        <p class="mt-6 text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text dark:from-blue-600 dark:to-indigo-600">{{ __('footer.no_categories') }}</p>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 mt-6">
            @foreach ($categories as $category)
                <a class="group flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl hover:shadow-md focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800" href="{{ url(app()->getLocale() . '/categories/' . $category->id) }}">
                    <div class="p-4 md:p-5">
                        <div class="flex gap-x-5 items-center">
                            <!-- Placeholder Icon -->
                            <svg class="mt-0 shrink-0 size-5 text-gray-800 dark:text-neutral-200" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 16v.01"/>
                                <path d="M12 8v4"/>
                            </svg>
                            <div class="grow">
                                <h3 class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-blue-600 dark:text-neutral-200">
                                    {{ app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</section>