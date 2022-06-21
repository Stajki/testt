<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::user()) {
        return view('home');
    }

    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/products/add', function () {
            return view('product.admin.new');
        });
        Route::post('/products/add', [\App\Http\Controllers\ProductController::class, 'store']);
        Route::post('/products/{productId}/update', [\App\Http\Controllers\ProductController::class, 'update'])
            ->where('productId', '[0-9]+');
        Route::post('/products/{productId}/delete', [\App\Http\Controllers\ProductController::class, 'destroy'])
            ->where('productId', '[0-9]+');
        Route::post('/products/{productId}/restore', [\App\Http\Controllers\ProductController::class, 'restore'])
            ->where('productId', '[0-9]+');
        Route::get('/products/{productId}', [\App\Http\Controllers\ProductController::class, 'show'])
            ->where('productId', '[0-9]+');
    });

    Route::post('/cart/product/{productId}', [App\Http\Controllers\CartController::class, 'update'])
        ->where('productId', '[0-9]+');
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'show']);

    Route::post('/order', [App\Http\Controllers\OrderController::class, 'store']);
    Route::get('/order', [App\Http\Controllers\OrderController::class, 'index']);
    Route::get('/order/{orderId}', [App\Http\Controllers\OrderController::class, 'show'])
        ->where('orderId', '[0-9]+');

    Route::get('/users/edit', [\App\Http\Controllers\UserController::class, 'show']);
    Route::post('/users/edit', [\App\Http\Controllers\UserController::class, 'update']);
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/users/{userId}/edit', [\App\Http\Controllers\UserController::class, 'show'])
            ->where('userId', '[0-9]+');
        Route::post('/users/{userId}/edit', [\App\Http\Controllers\UserController::class, 'update'])
            ->where('userId', '[0-9]+');
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
        Route::post('/users/{userId}/delete', [\App\Http\Controllers\UserController::class, 'destroy'])
            ->where('userId', '[0-9]+');
        Route::post('/users/{userId}/restore', [\App\Http\Controllers\UserController::class, 'restore'])
            ->where('userId', '[0-9]+');
        Route::get('/users/add', function () {
            return view('user.admin.new');
        });
        Route::post('/users/add', [\App\Http\Controllers\UserController::class, 'create']);
    });
});
