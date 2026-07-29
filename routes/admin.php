<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

// ⬇️ راوتات مفتوحة (بدون أي auth)
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

// ⬇️ راوتات محمية (auth + admin role)
Route::middleware(['admin'])->group(function () {

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users CRUD
    Route::resource('users', UserController::class);

    // Products CRUD
    Route::resource('products', ProductController::class);

    // Categories CRUD
    Route::resource('categories', CategoryController::class);

    // SubCategories CRUD
    Route::resource('subcategories', SubCategoryController::class);

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::put('/orders/{id}/payment', [OrderController::class, 'updatePayment'])->name('orders.payment');

    // Reports
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/products', [ReportController::class, 'products'])->name('reports.products');
    Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
});
