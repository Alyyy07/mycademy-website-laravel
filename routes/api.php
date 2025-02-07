<?php

use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->middleware('auth:sanctum')->group(function () {
    Route::get('logout',[AuthApiController::class, 'logout']);
});

Route::middleware(['checkClientId', 'throttle:60,1'])->group(function () {
    Route::post('login', [AuthApiController::class, 'login']);

    Route::post('register',[AuthApiController::class, 'register']);

    Route::get('verify-email',[AuthApiController::class, 'sendVerificationEmail']);

    Route::post('verify-email', [AuthApiController::class, 'verifyEmail']);

    Route::get('verification-code', [AuthApiController::class, 'getVerificationCode']);
});
