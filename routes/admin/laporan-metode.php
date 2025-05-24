<?php

use App\Http\Controllers\LaporanMetodeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'laporan-metode', 'as' => 'laporan-metode.'], function () {
    Route::get('/', [LaporanMetodeController::class, 'index'])->name('index');
    Route::get('/detail', [LaporanMetodeController::class, 'detail'])->name('detail');
    Route::get('/laporan/{mappingId}/export', [LaporanMetodeController::class, 'exportExcel'])->name('export');
});