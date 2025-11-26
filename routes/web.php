<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerAuthController;

Route::get('/', function () {
    return redirect('/penjual/register');
});

Route::get('/penjual/register', [SellerAuthController::class, 'registerView'])->name('seller.register');
Route::post('/penjual/register', [SellerAuthController::class, 'register'])->name('seller.register.submit');