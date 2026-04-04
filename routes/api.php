<?php

use App\Http\Controllers\Api\V1\{OrderController, ProductController, UserController};
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    
    Route::apiResource('users', UserController::class)->except(['store']);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class);

    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel']);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus']);
});