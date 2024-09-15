<?php

use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\UserListController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'user-management','as' => 'user-management.'],function(){
    Route::resource('/users',UserListController::class)->names('users');
    Route::resource('/roles',RoleController::class)->names('roles');
})->middleware('role:admin');