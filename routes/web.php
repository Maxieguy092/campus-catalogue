<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\ProductController;
use App\Models\Seller;
use App\Mail\SellerStatusChanged;
use Illuminate\Support\Facades\Mail;

// Redirect default ke halaman register seller
Route::get('/', function () {
    return redirect()->route('catalogue');
});

// =========================
// SELLER AUTH REGISTER
// =========================
Route::get('/seller/register', [SellerAuthController::class, 'registerView'])
    ->name('seller.register');

Route::post('/seller/register', [SellerAuthController::class, 'register'])
    ->name('seller.register.submit');

Route::get('/seller/products', [ProductController::class, 'sellerIndex'])->name('seller.products');
Route::get('/seller/products/create', [ProductController::class, 'sellerCreate'])->name('seller.products.create');
Route::post('/seller/products/store', [ProductController::class, 'sellerStore'])->name('seller.products.store');
Route::get('/seller/products/{id}/edit', [ProductController::class, 'sellerEdit'])->name('seller.products.edit');
Route::put('/seller/products/{id}/update', [ProductController::class, 'sellerUpdate'])->name('seller.products.update');
Route::delete('/seller/products/{id}/delete', [ProductController::class, 'sellerDelete'])->name('seller.products.delete');
// Seller Login
Route::get('/seller/login', [SellerAuthController::class, 'loginView'])->name('seller.login');
Route::post('/seller/login', [SellerAuthController::class, 'login'])->name('seller.login.submit');


// =========================
// PLATFORM ADMIN DASHBOARD
// =========================
Route::get('/platform/dashboard', [PlatformController::class, 'dashboard'])
    ->name('platform.dashboard');

Route::post('/platform/seller/{id}/approve', [PlatformController::class, 'approve'])
    ->name('platform.seller.approve');

Route::post('/platform/seller/{id}/reject', [PlatformController::class, 'reject'])
    ->name('platform.seller.reject');

Route::get('/platform/seller/{id}/detail', [PlatformController::class, 'detail'])
    ->name('platform.seller.detail');

Route::get('/platform/seller/{id}', [PlatformController::class, 'detail'])
     ->name('platform.seller.detail');

Route::get('/platform/categories', [PlatformController::class, 'categories'])
    ->name('platform.categories');

Route::post('/platform/categories/store', [PlatformController::class, 'storeCategory'])
    ->name('platform.categories.store');

Route::delete('/platform/categories/{id}', [PlatformController::class, 'deleteCategory'])
    ->name('platform.categories.delete');

// =========================
// Catalogue Pages
// =========================

Route::get('/catalogue', [ProductController::class, 'index'])->name('catalogue');

// =========================
// TEST EMAIL (temporary)
// =========================
Route::get('/test-email', function () {
    $seller = Seller::find(1);
    
    if (!$seller) {
        return 'Seller dengan ID 1 tidak ditemukan';
    }
    
    try {
        Mail::to('rendhmr@gmail.com')->send(new SellerStatusChanged($seller, 'accepted'));
        return 'Email berhasil dikirim ke rendhmr@gmail.com!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
