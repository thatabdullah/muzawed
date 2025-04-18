<section class="w-full bg-gradient-to-r from-blue-200 to-cyan-200 dark:bg-gradient-to-r dark:from-gray-950 dark:to-neutral-900 py-10 px-4 sm:px-6 lg:px-8 mx-auto" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Grid -->
      <div class="grid md:grid-cols-2 gap-4 md:gap-8 xl:gap-20 md:items-center">
          <!-- Left Column (Slogan, Buttons, Reviews) -->
          <div class="space-y-6">
              <h1 class="block text-3xl font-bold text-gray-800 sm:text-4xl lg:text-6xl lg:leading-tight dark:text-white">
                  {{ __('homepage.slogan') }} <span class="bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text dark:from-blue-600 dark:to-indigo-600">{{__('homepage.muzawed')}}</span>
              </h1>
              <p class="mt-3 text-lg font-medium text-gray-800 dark:text-neutral-200">{{ __('homepage.sub_slogan') }}</p>
              <!-- Buttons -->
              <div class="mt-7 flex w-full {{ app()->getLocale() === 'ar' ? 'justify-start' : 'justify-start' }}">
                <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-lg border border-transparent bg-gradient-to-r from-blue-600 to-blue-800 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ url(app()->getLocale() . '/products') }}">
                    {{ __('homepage.explore_button') }}
                    <svg class="flex-shrink-0 w-4 h-4 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </a>
            </div>
              <!-- Reviews -->
              <div class="mt-6 lg:mt-10 grid grid-cols-2 gap-x-5">
                  <!-- Review 1 -->
                  <div class="py-5 flex flex-col">
                      <div class="flex {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-1' : 'space-x-1' }}">
                          <svg class="h-4 w-4 text-gray-800 dark:text-neutral-200" width="51" height="51" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M27.0352 1.6307L33.9181 16.3633..." fill="currentColor" />
                          </svg>
                          <!-- Repeat 5 stars -->
                      </div>
                      <p class="mt-3 text-sm text-gray-800 dark:text-neutral-200">
                         {{-- {{ __('homepage.review_1_score') }} --}}
                      </p>
                      <div class="mt-5 flex items-center h-16">
                        {{-- <img src="https://app.sa.focal.mozn.sa/images/site_thumbnail.png" alt="{{ __('messages.logo_alt') }}" class="h-auto w-16" /> --}}
                      </div>
                  </div>
                  <!-- Review 2 -->
                  <div class="py-5 flex flex-col">
                      <div class="flex {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-1' : 'space-x-1' }}">
                          <svg class="h-4 w-4 text-gray-800 dark:text-neutral-200" width="51" height="51" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M27.0352 1.6307L33.9181 16.3633..." fill="currentColor" />
                          </svg>
                          <!-- Repeat 4 stars + half -->
                      </div>
                      <p class="mt-3 text-sm text-gray-800 dark:text-neutral-200">
                         {{-- {{ __('homepage.review_2_score') }} --}}
                      </p>
                      <div class="mt-5 flex items-center h-16">
                      {{--  <img src="https://dubai.stepconference.com/wp-content/uploads/2023/02/P32-LISAN-LOGO-HORIZONTAL-01-Noor-Alasadi.png" alt="{{ __('messages.logo_alt') }}" class="h-auto w-16" /> --}}
                      </div>
                  </div>
              </div>
          </div>
          <!-- Right Column (Image) -->
          <div class="relative">
              <img class="max-w-md w-full rounded-md mx-auto" src="https://static.vecteezy.com/system/resources/thumbnails/047/247/466/small/3d-code-icon-programming-code-symbols-software-and-web-development-icon-png.png" alt="SaaS Image">
              <div class="absolute inset-0 -z-[1] bg-gradient-to-tr from-gray-200 via-white/0 to-white/0 w-full h-full rounded-md mt-4 -mb-4 lg:mt-6 lg:-mb-6"></div>
          </div>
      </div>
  </div>
  @livewire('featured-products')
  @livewire('categories-section')

</div>
