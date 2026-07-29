<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\OrderController as FrontendOrderController;
use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// ⬇️ إضافة route login الافتراضية (تعيد التوجيه للعميل)
Route::get('/login', [FrontendAuthController::class, 'showLogin'])->name('login');

// باقي الروابط كما هي...
Route::get('/customer/login', [FrontendAuthController::class, 'showLogin'])->name('customer.login');
Route::post('/customer/login', [FrontendAuthController::class, 'login'])->name('customer.login.post');
Route::get('/register', [FrontendAuthController::class, 'showRegister'])->name('customer.register');
Route::post('/register', [FrontendAuthController::class, 'register'])->name('customer.register.post');
Route::post('/logout', [FrontendAuthController::class, 'logout'])->name('customer.logout');

// Language Switcher
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session()->put('locale', $locale);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');

// Products
Route::get('/products', [FrontendProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [FrontendProductController::class, 'show'])->name('products.show');
Route::get('/category/{id}', [FrontendProductController::class, 'category'])->name('category.show');
Route::get('/search', [FrontendProductController::class, 'search'])->name('products.search');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Protected Customer Routes
Route::middleware([\App\Http\Middleware\CustomerAuth::class])->group(function () {
    Route::get('/checkout', [FrontendOrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [FrontendOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/success/{id}', [FrontendOrderController::class, 'success'])->name('orders.success');
    Route::get('/orders', [FrontendOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [FrontendOrderController::class, 'show'])->name('orders.show');
    Route::get('/profile', [FrontendAuthController::class, 'profile'])->name('customer.profile');
    Route::put('/profile', [FrontendAuthController::class, 'updateProfile'])->name('customer.profile.update');
});
