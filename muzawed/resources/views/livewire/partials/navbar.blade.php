<header class="flex z-50 sticky top-0 flex-wrap md:justify-start md:flex-nowrap w-full bg-black text-sm py-3 md:py-0 dark:bg-black">
  <nav class="max-w-[85rem] w-full mx-auto px-4 md:px-6 lg:px-8" aria-label="Global">
      <div class="relative md:flex md:items-center md:justify-between">
          <div class="flex items-center justify-between">
              <a class="flex-none text-xl font-semibold text-white dark:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ url('/') }}" aria-label="Brand">Muzawed</a>
              <div class="md:hidden">
                  <button type="button" class="hs-collapse-toggle flex justify-center items-center w-9 h-9 text-sm font-semibold rounded-lg border border-gray-200 text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-collapse="#navbar-collapse-with-animation" aria-controls="navbar-collapse-with-animation" aria-label="Toggle navigation">
                      <svg class="hs-collapse-open:hidden flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <line x1="3" x2="21" y1="6" y2="6" />
                          <line x1="3" x2="21" y1="12" y2="12" />
                          <line x1="3" x2="21" y1="18" y2="18" />
                      </svg>
                      <svg class="hs-collapse-open:block hidden flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
          </div>
          <div id="navbar-collapse-with-animation" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block">
              <div class="overflow-hidden overflow-y-auto max-h-[75vh] [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-slate-700 dark:[&::-webkit-scrollbar-thumb]:bg-slate-500">
                  <div class="flex flex-col gap-x-0 mt-5 divide-y divide-dashed divide-gray-200 md:flex-row md:items-center md:gap-x-7 md:mt-0 md:ps-7 md:divide-y-0 md:divide-solid dark:divide-gray-700 md:justify-end">
                    <a class="font-medium {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-500' : 'text-gray-400 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-600' }} py-3 md:py-6 " href="{{ url(app()->getLocale()) }}" @if(request()->routeIs('home')) aria-current="page" @endif>{{ __('navbar.home') }}</a>
                    <a class="font-medium {{ request()->routeIs('categories') ? 'text-blue-600 dark:text-blue-500' : 'text-gray-400 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-600' }} py-3 md:py-6" href="{{ url(app()->getLocale() . '/categories') }}" @if(request()->routeIs('categories')) aria-current="page" @endif>{{ __('navbar.categories') }}</a>
                    <a class="font-medium {{ request()->routeIs('products') ? 'text-blue-600 dark:text-blue-500' : 'text-gray-400 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-600' }} py-3 md:py-6 " href="{{ url(app()->getLocale() . '/products') }}" @if(request()->routeIs('products')) aria-current="page" @endif>{{ __('navbar.saas_products') }}</a>
                    @guest
                    <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="ml-4 text-sm font-medium text-gray-400 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-600 font-manrope">{{ __('Sign in') }}</a>
                    @livewire('language-switcher')
                    @else
                    @livewire('language-switcher')
                            <a href="{{ route('profile', ['locale' => app()->getLocale()]) }}" class="flex items-center space-x-2 py-3 md:py-6 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }} hover:text-blue-600 dark:hover:text-blue-500">
                                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-600">
                                    <span class="text-white font-medium {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </span>
                                <span class="text-sm font-bold text-gray-400 dark:text-gray-400 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ auth()->user()->name }}</span>
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
</div>
</nav>
</header>