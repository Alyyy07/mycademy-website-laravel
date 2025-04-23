<?php

use App\Http\Controllers\ModulPembelajaranController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'modul-pembelajaran', 'as' => 'modul-pembelajaran.'], function () {
    Route::get('/', [ModulPembelajaranController::class, 'index'])->name('index');

    Route::get('/create-materi', [ModulPembelajaranController::class, 'createMateri'])->name('materi.create');
    Route::post('/create-detail-materi', [ModulPembelajaranController::class, 'createDetailMateri'])->name('materi.create-detail');
    Route::post('/store-materi', [ModulPembelajaranController::class, 'storeMateri'])->name('materi.store');

    Route::get('/{id}/edit-materi', [ModulPembelajaranController::class, 'editMateri'])->name('materi.edit');
    Route::put('/{id}/update-materi', [ModulPembelajaranController::class, 'updateMateri'])->name('materi.update');

    Route::delete('/{id}/destroy-materi', [ModulPembelajaranController::class, 'destroyMateri'])->name('materi.destroy');

    Route::get('/create-kuis', [ModulPembelajaranController::class, 'createKuis'])->name('kuis.create');
    Route::post('/store-kuis', [ModulPembelajaranController::class, 'storeKuis'])->name('kuis.store');

    Route::get('/{id}/edit-kuis', [ModulPembelajaranController::class, 'editKuis'])->name('kuis.edit');
    Route::put('/{id}/update-kuis', [ModulPembelajaranController::class, 'updateKuis'])->name('kuis.update');

    Route::delete('/{id}/destroy-kuis', [ModulPembelajaranController::class, 'destroyKuis'])->name('kuis.destroy');

    Route::get('/detail', [ModulPembelajaranController::class, 'detail'])->name('detail');

    Route::post('/upload/materi/file', [ModulPembelajaranController::class, 'uploadFile'])->name('materi.file.upload');
    Route::post('/delete/materi/file', [ModulPembelajaranController::class, 'deleteFile'])->name('materi.file.delete');

    Route::post('/status-materi', [ModulPembelajaranController::class, 'updateStatusMateri'])->name('materi.status');
    Route::post('/status-kuis', [ModulPembelajaranController::class, 'updateStatusKuis'])->name('kuis.status');

    Route::post('/reset-status-kuis', [ModulPembelajaranController::class, 'resetStatusKuis'])->name('kuis.status.reset');
    Route::post('/reset-status-materi', [ModulPembelajaranController::class, 'resetStatusMateri'])->name('materi.status.reset');

    Route::post('/end-session', [ModulPembelajaranController::class, 'endSession'])->name('end-session');
    Route::post('/end-forum',[ModulPembelajaranController::class,'endForum'])->name('end-forum');
});
