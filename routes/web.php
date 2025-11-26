<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect('/penjual/register');
});

// Route::view('/catalogue', 'catalogue')->name('catalogue');

Route::get('/catalogue', [ProductController::class, 'index'])->name('catalogue');

Route::get('/penjual/register', [SellerAuthController::class, 'registerView'])->name('seller.register');

Route::post('/penjual/register', [SellerAuthController::class, 'register'])->name('seller.register.submit');