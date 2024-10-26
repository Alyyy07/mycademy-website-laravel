<?php

use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\UserListController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user-management', 'as' => 'user-management.'], function () {
    Route::resource('/users', UserListController::class)->names('users');
    Route::patch('/users/set-status/{user}', [UserListController::class, 'setStatus'])->name('users.setStatus');
    Route::post('/users/bulk-set-status/', [UserListController::class, 'bulkSetStatus'])->name('users.bulkSetStatus');
    Route::delete('/users',[UserListController::class,'bulkDelete'])->name('users.bulkDelete');
    
    Route::resource('/roles', RoleController::class)->names('roles');
});