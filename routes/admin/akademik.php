<?php

use App\Http\Controllers\TahunAjaranController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'akademik', 'as' => 'akademik.'], function () {
    Route::resource('/tahun-ajaran', TahunAjaranController::class)->names('tahun-ajaran')->except('show');
    Route::patch('/tahun-ajaran/set-status/{tahunAjaran}', [TahunAjaranController::class, 'setStatus'])->name('tahun-ajaran.setStatus');
});