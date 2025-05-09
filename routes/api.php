<?php

use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->middleware(['checkClientId'])->group(function () {
    Route::post('logout',[AuthApiController::class, 'logout']);

    Route::get('matakuliah',[AuthApiController::class, 'getMataKuliah']);
    Route::get('modul-pembelajaran',[AuthApiController::class, 'getMataKuliahById']);
    Route::get('modul-pembelajaran/materi',[AuthApiController::class, 'getMateri']);
    Route::post('modul-pembelajaran/materi-selesai',[AuthApiController::class, 'setMateriSelesai']);
    Route::get('modul-pembelajaran/kuis',[AuthApiController::class, 'getKuis']);
    Route::post('modul-pembelajaran/kuis-selesai',[AuthApiController::class, 'setKuisSelesai']);

    Route::get('modul-pembelajaran/forum-diskusi',[AuthApiController::class, 'getForumDiskusi']);
    Route::post('modul-pembelajaran/forum-diskusi/send',[AuthApiController::class, 'sendForumDiskusi']);
});

Route::middleware(['checkClientId', 'throttle:60,1'])->group(function () {
    Route::post('login', [AuthApiController::class, 'login']);
    // Route::post('/login-with-google', [AuthApiController::class, 'loginWithGoogle']);

    Route::post('register',[AuthApiController::class, 'register']);

    Route::get('verify-email',[AuthApiController::class, 'sendVerificationEmail']);

    Route::post('verify-email', [AuthApiController::class, 'verifyEmail']);

    Route::get('verification-code', [AuthApiController::class, 'getVerificationCode']);
});
