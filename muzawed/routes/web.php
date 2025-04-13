<?php

use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');

Route::prefix('{locale}')->where(['locale' => 'en|ar'])->group(function () {
    Route::get('/', HomePage::class)->name('home.locale');
});