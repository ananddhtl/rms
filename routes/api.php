<?php

use App\Http\Controllers\Api\V1\AuthApiController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CartApiController;
use App\Http\Controllers\Api\V1\MenuApiController;
use App\Http\Controllers\Api\V1\OrderApiController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\ProductApiController;
use App\Http\Controllers\Api\V1\ProductCategoryApiController;
use App\Http\Controllers\Api\V1\ProductCategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\TableApiController;
use App\Http\Controllers\Api\V1\TableController;
use Illuminate\Support\Facades\Route;

Route::prefix('rms')->name('api.')->group(function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [AuthApiController::class, 'signup']);
        Route::post('login', [AuthApiController::class, 'login']);

        Route::middleware('auth:api')->group(function () {
            Route::post('logout', [AuthApiController::class, 'logout']);

            Route::post('change-password', [AuthApiController::class, 'changePassword']);
        });
        
        Route::post('forgot-password', [AuthApiController::class, 'forgotPassword']);
        Route::post('verify-otp', [AuthApiController::class, 'forgotOTPVerify']);
        Route::post('reset-password', [AuthApiController::class, 'resetPassword']);
    });

    // Route::prefix('auth')->name('auth.')->group(function () {

    //     Route::middleware('auth:sanctum')->group(function () {
    //         Route::post('verify-otp', [AuthController::class, 'verifyOTP']);
    //         Route::post('logout', [AuthController::class, 'logout']);
    //         Route::get('user-profile', [AuthController::class, 'user']);
    //         Route::post('change-password', [AuthController::class, 'changePassword']);
    //     });
    //     Route::post('login', [AuthController::class, 'login']);
    //     Route::post('register', [AuthController::class, 'register']);
    //     Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    //     Route::post('reset-password', [AuthController::class, 'resetPassword']);

    //     Route::post('send-password-reset-token', [AuthController::class, 'sendPasswordResetToken'])->name('sendPasswordResetToken');
    //     Route::post('verify-password-reset-token', [AuthController::class, 'verifyPasswordResetToken'])->name('verifyPasswordResetToken');
    // });

    Route::get('products', ProductApiController::class);
    Route::get('products-by-id/{id}', [ProductApiController::class, 'getProductById']);
    Route::get('search-products', [ProductApiController::class, 'searchProducts']);

    Route::post('product/{id}/order', OrderController::class);
    Route::post('order/{id}/payment', PaymentController::class);

    //category
    Route::get('product-categories', ProductCategoryApiController::class);
    Route::get('products-by-category', [ProductCategoryApiController::class, 'productsByCategory']);
    
    //menu
    Route::get('/menu', [MenuApiController::class, 'getMenu']);

    // table
    Route::get('tables', TableApiController::class);
    Route::post('tables/reservation', [TableApiController::class, 'tableReservation']);
    Route::post('tables/unreserve', [TableApiController::class, 'unReserveTable']);
    Route::get('tables/available', [TableApiController::class, 'getAvailableTable']);
    Route::get('my-reserved-tables', [TableApiController::class, 'getMyReservedTables']);

    Route::middleware('api')->group(function () {
        //cart
        Route::get('cart', [CartApiController::class, 'getCart']);
        Route::post('add-to-cart', [CartApiController::class, 'addToCart']);
        Route::post('update-cart-item', [CartApiController::class, 'updateCartItem']);
        Route::post('delete-cart-item', [CartApiController::class, 'deleteCartItem']);

        //order
        Route::post('checkout', [OrderApiController::class, 'checkout']);
        Route::get('orders', [OrderApiController::class, 'getOrders']);
        Route::get('order-details', [OrderApiController::class, 'getOrderById']);
    });
});
