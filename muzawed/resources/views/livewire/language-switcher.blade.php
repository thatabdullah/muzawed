@php
    $currentLocale = app()->getLocale();
    $targetLocale = $currentLocale === 'ar' ? 'en' : 'ar';
    $segments = request()->segments();

    if (count($segments) > 0 && in_array($segments[0], ['en', 'ar'])) {
        $segments[0] = $targetLocale;
    } else {
        array_unshift($segments, $targetLocale);
    }

    $switchUrl = '/' . implode('/', $segments);
@endphp

<a href="{{ $switchUrl }}"
   class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg 
bg-white text-black border border-black 
dark:bg-black dark:text-white dark:border-neutral-700 
hover:bg-gray-100 dark:hover:bg-neutral-800 
transition-colors duration-200 
disabled:opacity-50 disabled:pointer-events-none">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M12 3v1m0 16v1m8-9h1M3 12H2m15.36 6.36l.7.7M5.64 5.64l-.7-.7m0 13.42l.7-.7m13.42-13.42l-.7.7M8 12a4 4 0 108 0 4 4 0 00-8 0z"/>
    </svg>
    {{ $targetLocale === 'ar' ? 'Arabic' : 'English' }}
</a>
