<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CheckoutController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index'); // maps to listing.blade.php
    Route::get('/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/category/{slug}', [ProductController::class, 'category'])->name('products.category');
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show'); // maps to details.blade.php
});

Route::prefix('account')->middleware('auth')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('account.index'); // profile.blade.php
    Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::get('/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/orders/{id}', [AccountController::class, 'orderDetails'])->name('account.order_details');
    Route::get('/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
});

Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::get('/confirmation', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
});

Route::get('/cart', function() { return view('cart.index'); })->name('cart.index');
Route::get('/wishlist', function() { return view('wishlist.index'); })->name('wishlist.index');

// Temporary Auth Routes
Route::get('/login', [HomeController::class, 'index'])->name('login'); // Redirect to home so modal can be shown or handled via query param
Route::post('/login', function() { return redirect()->back(); }); // Accept POST but do nothing
Route::post('/register', function() { return redirect()->back(); })->name('register');
Route::post('/logout', function() { return redirect()->back(); })->name('logout');
