<div class="space-y-6">
    <!-- Header with Add Button -->
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
            Your Subscriptions
        </h3>
        <button wire:click="toggleForm" @class([
            'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2',
            'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500' => !$showForm,
            'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500' => $showForm,
        ])>
            {{ $showForm ? 'Cancel' : 'Add Subscription' }}
        </button>
    </div>

    <!-- Add/Edit Form -->
    @if($showForm)
    <div class="bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-2xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
            {{ $editingId ? __('Edit Subscription') : __('Add New Subscription') }}
        </h3>
    
        <form wire:submit.prevent="saveSubscription">
            <div class="space-y-5">
                <!-- Product Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                        {{ __('Product') }}
                    </label>
                    <select wire:model="form.saas_product_id" class="mt-1 block w-full pl-3 pr-10 py-2.5 text-base border border-gray-200 dark:border-neutral-800 dark:bg-neutral-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                        <option value="" class="text-gray-500 dark:text-gray-400">Select a product</option>
                        @foreach(\App\Models\Product::all() as $product)
                        <option value="{{ $product->id }}" class="text-gray-500 dark:text-gray-400">{{ $product->name }}</option>             
                        @endforeach
                    </select>
                    @error('form.saas_product_id')
                        <p class="mt-1 text-sm text-red-600 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ $message }}</p>
                    @enderror
                </div>
    
                <!-- Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                            {{ __('Start Date') }}
                        </label>
                        <input type="date" wire:model="form.start_date" class="mt-1 block w-full py-2.5 px-3 border border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                        @error('form.start_date')
                            <p class="mt-1 text-sm text-red-600 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                            {{ __('End Date') }} <span class="text-gray-500 text-xs">({{ __('optional') }})</span>
                        </label>
                        <input type="date" wire:model="form.end_date" class="mt-1 block w-full py-2.5 px-3 border border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                        @error('form.end_date')
                            <p class="mt-1 text-sm text-red-600 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
    
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                        {{ __('Price') }} <span class="text-gray-500 text-xs">({{ __('optional') }})</span>
                    </label>
                    <div class="mt-1 relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                            
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/98/Saudi_Riyal_Symbol.svg" 
                    class="h-5 w-5 filter dark:invert dark:brightness-75"
                    alt="SAR">
                        </div>
                        <input type="number" step="0.01" wire:model="form.price" 
                            class="block w-full py-2.5 px-3 {{ app()->getLocale() === 'ar' ? 'pr-10' : 'pl-10' }} border border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}" 
                            placeholder="0.00">
                    </div>
                    @error('form.price')
                        <p class="mt-1 text-sm text-red-600 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">{{ $message }}</p>
                    @enderror
                </div>
    
                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-manrope' }}">
                        {{ $editingId ? __('Update Subscription') : __('Add Subscription') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif

    <!-- Subscriptions List -->
   <<div class="space-y-4">
    @forelse($subscriptions as $subscription)
    <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-sm border border-gray-200 dark:border-neutral-800 overflow-hidden transition-all duration-200 hover:shadow-md">
        <div class="p-5 {{ app()->getLocale() === 'ar' ? 'text-right' : '' }}">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-3 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                        <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-base font-medium text-gray-900 dark:text-white truncate">
                                {{ $subscription->product->name ?? 'Unknown Product' }}
                            </h4>
                            <div class="flex items-center mt-1 text-sm text-gray-500 dark:text-gray-400">
                                <span>{{ $subscription->start_date->format('M d, Y') }}</span>
                                <span class="mx-2">-</span>
                                <span>{{ $subscription->end_date?->format('M d, Y') ?? 'No end date' }}</span>
                            </div>
                        </div>
                    </div>

                    @if($subscription->end_date)
                    <div class="mt-4">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-gray-500 dark:text-gray-400">Time remaining:</span>
                            <span class="font-medium {{ now()->diffInDays($subscription->end_date) < 15 ? 'text-red-500' : 'text-blue-500' }}">
                                {{ round(now()->diffInDays($subscription->end_date)) }} days
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                            @php
                                $totalDuration = $subscription->start_date->diffInDays($subscription->end_date);
                                $elapsedDays = max(0, $subscription->start_date->diffInDays(now()));
                                $remainingPercentage = max(0, 100 - ($elapsedDays / $totalDuration * 100));
                                $color = match(true) {
                                    $remainingPercentage > 30 => 'bg-blue-500',
                                    $remainingPercentage > 10 => 'bg-yellow-500',
                                    default => 'bg-red-500'
                                };
                            @endphp
                            <div class="h-2 rounded-full {{ $color }}" style="width: {{ $remainingPercentage }}%"></div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="{{ app()->getLocale() === 'ar' ? 'mr-4' : 'ml-4' }} flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                    <button wire:click="edit({{ $subscription->id }})" class="p-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 rounded-full hover:bg-blue-50 dark:hover:bg-blue-900/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    <button wire:click="delete({{ $subscription->id }})" class="p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>

            @if($subscription->price)
            <div class="mt-3 flex items-center justify-between">
                <span class="text-sm text-gray-500 dark:text-gray-400">Price:</span>
                <div class="flex items-center space-x-1 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ number_format($subscription->price, 2) }}
                    </span>
                    <div class="flex items-center pointer-events-none">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/9/98/Saudi_Riyal_Symbol.svg" 
                             class="h-4 w-4 filter dark:invert dark:brightness-75"
                             alt="SAR">
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-sm border border-gray-200 dark:border-neutral-700 p-8 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No subscriptions yet</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 mb-4">Get started by adding your first subscription</p>
        <button wire:click="toggleForm" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Add Subscription
        </button>
    </div>
    @endforelse
</div>

@if($subscriptions->hasPages())
<div class="mt-4">
    {{ $subscriptions->links() }}
</div>
@endif