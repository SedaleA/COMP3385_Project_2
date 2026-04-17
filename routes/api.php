<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:api');

    Route::get('/services', [ServiceController::class, 'index']);
    Route::post('/services', [ServiceController::class, 'store'])->middleware('auth:api');
    Route::get('/services/{service}', [ServiceController::class, 'show']);
    Route::post('/services/{service}/favourite', [ServiceController::class, 'favourite'])->middleware('auth:api');
    Route::get('/search', [ServiceController::class, 'search']);

    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::get('/users/{user}/favourites', [UserController::class, 'favourites']);
});