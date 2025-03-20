<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MappingMatakuliahController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RpsMatakuliahController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});




Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    require __DIR__.'/admin/user-management.php';
    require __DIR__.'/admin/akademik.php';

    Route::resource('/mapping-matakuliah', MappingMatakuliahController::class)->names('mapping-matakuliah');
    Route::resource('/rps-matakuliah', RpsMatakuliahController::class)->names('rps-matakuliah');
    
});

require __DIR__.'/auth.php';
