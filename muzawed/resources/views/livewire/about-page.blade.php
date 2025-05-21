<section class="w-full bg-gradient-to-t from-blue-50 via-white to-cyan-50 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1IiBoZWlnaHQ9IjUiPjxwYXRoIGQ9Ik0yIDBoMXYxSDJ6TTEgMmgxdjFIMXoiIGZpbGw9InJnYmEoMCwwLDAsMC4wNSkiLz48L3N2Zz4=')] dark:bg-gradient-to-r dark:from-gray-950 dark:to-neutral-900 py-10 px-4 sm:px-6 lg:px-8 mx-auto" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="text-center mb-12">
      <h1 class="text-3xl font-black text-gray-800 sm:text-4xl lg:text-5xl lg:leading-tight dark:text-white">
        {{ __('about_us.title') }} <span class="bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text dark:from-blue-600 dark:to-indigo-600">{{ __('about_us.muzawed') }}</span>
      </h1>
      <p class="mt-3 text-lg font-medium text-gray-800 dark:text-neutral-200">{{ __('about_us.subtitle') }}</p>
    </div>

    <!-- Grid -->
    <div class="grid md:grid-cols-2 gap-4 md:gap-8 xl:gap-20 md:items-center">
      <!-- Left Column (Text Content) -->
      <div class="space-y-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('about_us.our_mission') }}</h2>
        <p class="text-gray-600 dark:text-neutral-300">{{ __('about_us.mission_description') }}</p>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('about_us.our_vision') }}</h2>
        <p class="text-gray-600 dark:text-neutral-300">{{ __('about_us.vision_description') }}</p>
        <div class="mt-7 flex {{ app()->getLocale() === 'ar' ? 'justify-start' : 'justify-start' }}">
          <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-lg border border-transparent bg-gradient-to-r from-blue-600 to-blue-800 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ url(app()->getLocale() . '/products') }}">
            {{ __('about_us.explore_products') }}
            <svg class="flex-shrink-0 w-4 h-4 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m9 18 6-6-6-6" />
            </svg>
          </a>
        </div>
      </div>
      <!-- Right Column (Image) -->
      <div class="relative">
        <img 
          class="max-w-md w-full rounded-md mx-auto block dark:hidden"
          src="{{ Storage::disk('s3')->url('logo/' . 'lightmode.png') }}" 
          alt="SaaS Light Logo"
        >
        <img 
          class="max-w-md w-full rounded-md mx-auto hidden dark:block"
          src="{{ Storage::disk('s3')->url('logo/' . 'darkmode.png') }}" 
          alt="SaaS Dark Logo"
        >
        <div class="absolute inset-0 -z-[1] bg-gradient-to-tr from-gray-200 via-white/0 to-white/0 w-full h-full rounded-md mt-4 -mb-4 lg:mt-6 lg:-mb-6"></div>
      </div>
    </div>

    <!-- Team Section -->
    <div class="mt-16 text-center">
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('about_us.our_team') }}</h2>
      <p class="mt-3 text-gray-600 dark:text-neutral-300">{{ __('about_us.team_description') }}</p>
      <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Team Member 1 -->
        <div class="flex flex-col items-center">
          <div class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600"></div>
          <h3 class="mt-4 text-lg font-semibold text-gray-800 dark:text-white">{{ __('about_us.team_member_1_name') }}</h3>
          <p class="text-gray-600 dark:text-neutral-300">{{ __('about_us.team_member_1_role') }}</p>
        </div>
        <!-- Team Member 2 -->
        <div class="flex flex-col items-center">
          <div class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600"></div>
          <h3 class="mt-4 text-lg font-semibold text-gray-800 dark:text-white">{{ __('about_us.team_member_2_name') }}</h3>
          <p class="text-gray-600 dark:text-neutral-300">{{ __('about_us.team_member_2_role') }}</p>
        </div>
        <!-- Team Member 3 -->
        <div class="flex flex-col items-center">
          <div class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600"></div>
          <h3 class="mt-4 text-lg font-semibold text-gray-800 dark:text-white">{{ __('about_us.team_member_3_name') }}</h3>
          <p class="text-gray-600 dark:text-neutral-300">{{ __('about_us.team_member_3_role') }}</p>
        </div>
      </div>
    </div>
  </div>
</section>