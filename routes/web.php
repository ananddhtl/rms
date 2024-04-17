<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('auth.show.login');
});

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('register', [AuthController::class, 'showRegisterPage'])->middleware(['guest', 'checkAdminRegistration'])->name('show.register');
    Route::post('register', [AuthController::class, 'register'])->middleware(['guest', 'checkAdminRegistration'])->name('register');
    Route::get('/login', [AuthController::class, 'showLoginPage'])->middleware('guest')->name('show.login');
    Route::post('login', [AuthController::class, 'login'])->middleware('guest')->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('files', FileController::class);
    Route::resource('users', UserController::class);
    Route::resource('categories', ProductCategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('tables', TableController::class);
    Route::resource('orders', OrderController::class);
});
