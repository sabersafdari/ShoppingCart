<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Website\OrderController;
use App\Http\Controllers\Website\ProductController as WebsiteProductController;
use App\Http\Controllers\Dashboard\ProductController as DashboardProductController;
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebsiteProductController::class, 'index'])->name('home');
Route::get('/product/{product}', [WebsiteProductController::class, 'show'])->name('product.show');
Route::post('/add-to-cart/{product}', [OrderController::class, 'addToCart'])->name('addToCart');
Route::get('/cart', [OrderController::class, 'cartShow'])->name('cartShow');
Route::delete('/remove-from-cart/{product}', [OrderController::class, 'removeFromCart'])->name('removeFromCart');
Route::patch('/update-cart/{product}', [OrderController::class, 'updateCart'])->name('updateCart');
Route::post('/cart/address', [OrderController::class, 'addAddress'])->name('addAddress');
Route::get('/invoice', [OrderController::class, 'invoice'])->name('invoice');
Route::post('/order/store', [OrderController::class, 'store'])->name('orderStore')->middleware('auth');
Route::match(['get','post'],'/pre-result', [OrderController::class, 'store'])->name('payResult');

Route::middleware('guest')
    ->prefix('auth')
    ->group(function () {
        Route::get('/login', [Authcontroller::class, 'loginView'])->name('login');
        Route::post('/login', [Authcontroller::class, 'loginSubmit'])->name('loginSubmit');
        Route::get('/register', [Authcontroller::class, 'registerView'])->name('register');
        Route::post('/register', [Authcontroller::class, 'registerSubmit'])->name('registerSubmit');
    });

Route::middleware('dashboard')
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::resource('/product', DashboardProductController::class);
    });

Route::get('/logout', [Authcontroller::class, 'logout'])->name('logout');
