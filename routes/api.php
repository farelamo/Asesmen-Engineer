<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'register']);
});

Route::middleware('auth.api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user/userlist', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
});