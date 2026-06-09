<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/register-company', [AuthController::class, 'registerCompany']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::prefix('api')->name('api.')->group(function () {
        Route::apiResource('companies', CompanyController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('orders', OrderController::class)->only(['index', 'show', 'store']);
        Route::apiResource('users', UserController::class);
        Route::post('/users/{user}/status', [UserController::class, 'setStatus']);
        Route::get('/permissions', [PermissionController::class, 'index']);

        // Cart routes
        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart/items', [CartController::class, 'addItem']);
        Route::put('/cart/items/{item}', [CartController::class, 'updateItem']);
        Route::delete('/cart/items/{item}', [CartController::class, 'removeItem']);
        Route::post('/cart/clear', [CartController::class, 'clear']);

        // Product image routes
        Route::post('/products/{product}/images', [ProductController::class, 'uploadImages']);
        Route::delete('/products/{product}/images/{image}', [ProductController::class, 'deleteImage']);
        Route::put('/products/{product}/images/{image}/primary', [ProductController::class, 'setPrimaryImage']);

        // Product video routes
        Route::post('/products/{product}/videos', [ProductController::class, 'uploadVideo']);
        Route::delete('/products/{product}/videos/{video}', [ProductController::class, 'deleteVideo']);

        // Product inventory routes
        Route::post('/products/{product}/locations', [ProductController::class, 'setLocations']);
        Route::post('/products/{product}/sizes', [ProductController::class, 'setSizes']);
        Route::post('/products/{product}/colors', [ProductController::class, 'setColors']);
    });
});
