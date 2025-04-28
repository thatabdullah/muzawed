<form wire:submit.prevent="toggleBookmark">
    @if ($isAuthenticated)
        <button type="submit" class="focus:outline-none text-white hover:text-yellow-300" title="{{ __('Bookmark') }}">
            <svg class="w-8 h-8 {{ $isBookmarked ? 'text-yellow-300 fill-current' : 'text-white' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M5 3v18l7-5 7 5V3H5z" />
            </svg>
        </button>
        @if ($error)
            <div class="mt-2 rounded-md bg-red-50 dark:bg-red-900/50 p-2">
                <p class="text-xs text-red-600 dark:text-red-300 {{ app()->getLocale() === 'ar' ? 'font-arabic text-right' : 'font-manrope' }}">{{ $error }}</p>
            </div>
        @endif
    @else
        <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="focus:outline-none text-white opacity-50 hover:text-yellow-300" title="{{ __('Sign in to bookmark') }}">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M5 3v18l7-5 7 5V3H5z" />
            </svg>
        </a>
    @endif
</form>