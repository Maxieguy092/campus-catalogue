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
Route::get('/seller/login', [SellerAuthController::class, 'loginView'])->name('seller.login');
Route::post('/seller/login', [SellerAuthController::class, 'login'])->name('seller.login.submit');


Route::middleware('seller_auth')->group(function () {
    // all seller-only routes here
    Route::get('/seller/dashboard', [ProductController::class, 'sellerDashboard'])->name('seller.dashboard');
    Route::get('/seller/dashboard/export-pdf', [ProductController::class, 'exportSellerDashboardPDF'])->name('seller.dashboard.export-pdf');

    // Laporan Penjual
    Route::get('/seller/reports/stock', [ProductController::class, 'exportSellerStockReport'])->name('seller.reports.stock');
    Route::get('/seller/reports/rating', [ProductController::class, 'exportSellerRatingReport'])->name('seller.reports.rating');
    Route::get('/seller/reports/low-stock', [ProductController::class, 'exportSellerLowStockReport'])->name('seller.reports.low-stock');

    Route::get('/seller/products', [ProductController::class, 'sellerIndex'])->name('seller.products');
    Route::get('/seller/products/create', [ProductController::class, 'sellerCreate'])->name('seller.products.create');
    Route::post('/seller/products/store', [ProductController::class, 'sellerStore'])->name('seller.products.store');
    Route::get('/seller/products/{id}/edit', [ProductController::class, 'sellerEdit'])->name('seller.products.edit');
    Route::put('/seller/products/{id}/update', [ProductController::class, 'sellerUpdate'])->name('seller.products.update');
    Route::delete('/seller/products/{id}/delete', [ProductController::class, 'sellerDelete'])->name('seller.products.delete');
    // Seller Login
});


// =========================
// PLATFORM ADMIN DASHBOARD
// =========================
Route::get('/platform/dashboard', [PlatformController::class, 'dashboard'])
    ->name('platform.dashboard');

Route::get('/platform/dashboard/export-pdf', [PlatformController::class, 'exportPlatformDashboardPDF'])
    ->name('platform.dashboard.export-pdf');

// Laporan Admin Platform
Route::get('/platform/reports/seller-list', [PlatformController::class, 'exportSellerListReport'])->name('platform.reports.seller-list');
Route::get('/platform/reports/store-by-province', [PlatformController::class, 'exportStoreByProvinceReport'])->name('platform.reports.store-by-province');
Route::get('/platform/reports/product-rating', [PlatformController::class, 'exportProductRatingReport'])->name('platform.reports.product-rating');

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
Route::get('/product/{id}', [ProductController::class, 'showDetail'])->name('product.detail');
Route::post('/product/{id}/rating', [ProductController::class, 'storeRating'])->name('product.rating.store');

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

// =========================
// TEMPORARY: Direct Access untuk Testing (hapus nanti)
// =========================
Route::get('/admin/dashboard-test', [PlatformController::class, 'dashboard'])
    ->name('admin.dashboard.test');
