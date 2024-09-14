<?php

use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\UserListController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'users','as' => 'users.'],function(){
    Route::resource('/user-list',UserListController::class)->names('user-list');
    Route::resource('/roles',RoleController::class)->names('roles');
})->middleware('role:admin');