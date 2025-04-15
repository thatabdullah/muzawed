<?php

use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;
use App\Livewire\ProductsPage;

Route::get('/', HomePage::class)->name('home');

Route::prefix('{locale}')->where(['locale' => 'en|ar'])->group(function () {
    Route::get('/', HomePage::class)->name('home.locale');
    Route::get('/products', ProductsPage::class)->name('products');
});