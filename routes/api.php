<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\CustomerController;

// Public routes (no authentication required)
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']); // Get all products
Route::get('/products/{id}', [ProductController::class, 'show']); // Get a single product by ID
Route::get('/customers/{customer}/retailer-phone', [CustomerController::class, 'getRetailerPhoneNumber']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Favorite routes
    Route::post('/favorites/add', [FavoriteController::class, 'addToFavorites']);
    Route::delete('/favorites/remove/{productId}', [FavoriteController::class, 'removeFromFavorites']);
    Route::get('/favorites', [FavoriteController::class, 'viewFavorites']);

    // Fetch customer ID for the authenticated user
    Route::get('/customer-id', [CustomerController::class, 'getCustomerId']);
});