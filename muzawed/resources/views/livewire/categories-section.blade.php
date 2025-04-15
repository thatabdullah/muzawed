<!-- resources/views/livewire/categories-section.blade.php -->
<section id="categories" class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <h2 class="text-2xl font-bold text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text dark:from-blue-600 dark:to-indigo-600">{{ __('footer.categories') }}</h2>
    @if ($categories->isEmpty())
        <p class="mt-6 text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text dark:from-blue-600 dark:to-indigo-600">{{ __('footer.no_categories') }}</p>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 mt-6">
            @foreach ($categories as $category)
                <a class="group flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl hover:shadow-md focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800" href="{{ url(app()->getLocale() . '/categories/' . $category->id) }}">
                    <div class="p-4 md:p-5">
                        <div class="flex gap-x-5 items-center">
                            <!-- Dynamic Feather Icon with Gradient -->
                            @php
                                $icon = $iconMap[$category->name_en] ?? 'circle';
                            @endphp
                            <svg class="mt-0 shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <defs>
                                    <linearGradient id="icon-gradient-{{ $category->id }}" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" class="stop-color-1" />
                                        <stop offset="100%" class="stop-color-2" />
                                    </linearGradient>
                                </defs>
                                @if ($icon === 'cloud')
                                    <path stroke="url(#icon-gradient-{{ $category->id }})" d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/>
                                @elseif ($icon === 'bar-chart-2')
                                    <path stroke="#2563eb" d="M18 20V10"/><path stroke="#2563eb" d="M12 20V4"/><path stroke="#2563eb" d="M6 20v-6"/>
                                @elseif ($icon === 'shield')
                                    <path stroke="url(#icon-gradient-{{ $category->id }})" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/>
                                @elseif ($icon === 'globe')
                                    <circle stroke="url(#icon-gradient-{{ $category->id }})" cx="12" cy="12" r="10"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M2 12h20"/>
                                @elseif ($icon === 'cpu')
                                    <rect stroke="url(#icon-gradient-{{ $category->id }})" width="16" height="16" x="4" y="4" rx="2"/><rect stroke="url(#icon-gradient-{{ $category->id }})" width="6" height="6" x="9" y="9" rx="1"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M15 2v2"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M15 20v2"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M2 15h2"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M2 9h2"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M20 15h2"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M20 9h2"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M9 2v2"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M9 20v2"/>
                                @elseif ($icon === 'briefcase')
                                    <rect stroke="url(#icon-gradient-{{ $category->id }})" width="20" height="14" x="2" y="7" rx="2" ry="2"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                @elseif ($icon === 'code')
                                    <path stroke="url(#icon-gradient-{{ $category->id }})" d="m16 18 6-6-6-6"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="m8 6-6 6 6 6"/>
                                @elseif ($icon === 'link')
                                    <path stroke="url(#icon-gradient-{{ $category->id }})" d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                                @elseif ($icon === 'database')
                                    <ellipse stroke="url(#icon-gradient-{{ $category->id }})" cx="12" cy="5" rx="9" ry="3"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M3 5V19A9 3 0 0 0 21 19V5"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M3 12A9 3 0 0 0 21 12"/>
                                @elseif ($icon === 'activity')
                                    <path stroke="url(#icon-gradient-{{ $category->id }})" d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                                @elseif ($icon === 'server')
                                    <rect stroke="url(#icon-gradient-{{ $category->id }})" width="20" height="8" x="2" y="2" rx="2" ry="2"/><rect stroke="url(#icon-gradient-{{ $category->id }})" width="20" height="8" x="2" y="14" rx="2" ry="2"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M6 6h.01"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M6 18h.01"/>
                                @elseif ($icon === 'lock')
                                    <rect stroke="url(#icon-gradient-{{ $category->id }})" width="18" height="11" x="3" y="11" rx="2" ry="2"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                @elseif ($icon === 'refresh-cw')
                                    <path stroke="url(#icon-gradient-{{ $category->id }})" d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M21 3v5h-5"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M8 16H3v5"/>
                                @elseif ($icon === 'message-square')
                                    <path stroke="url(#icon-gradient-{{ $category->id }})" d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/>
                                @elseif ($icon === 'dollar-sign')
                                    <path stroke="url(#icon-gradient-{{ $category->id }})" d="M12 2v20"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                @else
                                    <circle stroke="url(#icon-gradient-{{ $category->id }})" cx="12" cy="12" r="10"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M12 16v.01"/><path stroke="url(#icon-gradient-{{ $category->id }})" d="M12 8v4"/>
                                @endif
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