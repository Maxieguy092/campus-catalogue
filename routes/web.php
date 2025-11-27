<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\PlatformController;
use App\Models\Seller;
use App\Mail\SellerStatusChanged;
use Illuminate\Support\Facades\Mail;

// Redirect default ke halaman register seller
Route::get('/', function () {
    return redirect()->route('seller.register');
});

// =========================
// SELLER AUTH REGISTER
// =========================
Route::get('/seller/register', [SellerAuthController::class, 'registerView'])
    ->name('seller.register');

Route::post('/seller/register', [SellerAuthController::class, 'register'])
    ->name('seller.register.submit');

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
