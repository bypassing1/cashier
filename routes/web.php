<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/transaction', function () {
    return view('transaction');
});
Route::get('/api/products', [ProductController::class, 'getSelectedProducts']);
Route::get('/cashier', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::get('/register', function () {
    return view('layouts.register');
})->name('register.form');
// Route::get('/dashboard', function () {
//     return view('layouts.dashboard');
// });