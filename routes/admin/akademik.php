<?php

use App\Http\Controllers\FakultasController;
use App\Http\Controllers\DataMahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\TahunAjaranController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'akademik', 'as' => 'akademik.'], function () {
    Route::resource('/tahun-ajaran', TahunAjaranController::class)->names('tahun-ajaran')->except('show');
    Route::patch('/tahun-ajaran/set-status/{tahunAjaran}', [TahunAjaranController::class, 'setStatus'])->name('tahun-ajaran.setStatus');

    Route::resource('/matakuliah', MatakuliahController::class)->names('matakuliah')->except('show');

    Route::resource('/fakultas', FakultasController::class)->names('fakultas')->except('show')->whereNumber('fakultas');

    Route::resource('/prodi', ProdiController::class)->names('prodi')->except('show');

    Route::resource('/data-mahasiswa',DataMahasiswaController::class)->names('data-mahasiswa')->except(['show', 'create', 'store']);
});
