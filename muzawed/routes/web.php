<?php

use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;
use App\Livewire\ProductsPage;
use App\Livewire\CategoriesPage;
use App\Livewire\ProductDetailsPage;
use App\Livewire\LoginPage;
use App\Livewire\RegisterPage;
use App\Livewire\ForgotPasswordPage;
use App\Livewire\ProfilePage;
use App\Livewire\BookmarkToggle;
use App\Livewire\AboutPage;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
Route::get('/', HomePage::class)->name('home');

Route::prefix('{locale}')->where(['locale' => 'en|ar'])->group(function () {
    Route::get('/', HomePage::class)->name('home.locale');
    Route::get('/products', ProductsPage::class)->name('products');
    Route::get('/categories', CategoriesPage::class)->name('categories');
    Route::get('/products/{id}', ProductDetailsPage::class)->name('product.show');
    Route::get('/login', LoginPage::class)->name('login')->middleware('guest');
    Route::get('/register', RegisterPage::class)->name('register')->middleware('guest');
    Route::get('/forgot-password', ForgotPasswordPage::class)->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordPage::class, 'sendOtp'])->name('password.email'); 
    Route::get('/profile', ProfilePage::class)->name('profile')->middleware('auth');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/bookmarks/{productId}', [BookmarkToggle::class, 'toggleBookmark'])->name('bookmarks.toggle')->middleware('auth');
    Route::get('/about', AboutPage::class)->name('about');
});