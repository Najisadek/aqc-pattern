<?php

use App\Http\Controllers\Api\V1\{ProductController, UserController};
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::apiResource('users', UserController::class)->except(['store']);
    Route::apiResource('products', ProductController::class);
});