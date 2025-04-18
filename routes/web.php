<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MappingMatakuliahController;
use App\Http\Controllers\ModulPembelajaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RpsDetailController;
use App\Http\Controllers\RpsMatakuliahController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});




Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/upload-image', [UploadController::class, 'upload'])->middleware('web')->name('upload.image');
    Route::post('/delete-image', [UploadController::class, 'delete'])->middleware('web')->name('delete.image');

    require __DIR__ . '/admin/user-management.php';
    require __DIR__ . '/admin/akademik.php';
    require __DIR__ . '/admin/modul-pembelajaran.php';

    Route::resource('/mapping-matakuliah', MappingMatakuliahController::class)->names('mapping-matakuliah')->except('show');

    Route::resource('/rps-matakuliah', RpsMatakuliahController::class)->names('rps-matakuliah')->except('show');

    Route::resource('/rps-detail', RpsDetailController::class)->names('rps-detail')->except('show');
    Route::post('rps-detail/status-upload', [RpsDetailController::class, 'statusUpload'])->name('rps-detail.status-upload');
});

require __DIR__ . '/auth.php';
