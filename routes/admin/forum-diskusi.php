<?php

use App\Http\Controllers\DiscussionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'forum-diskusi', 'as' => 'forum-diskusi.'],function(){
    Route::get('/',[DiscussionController::class,'index'])->name('index');
    Route::get('/matakuliah/detail',[DiscussionController::class,'detail'])->name('detail');
    Route::get('/matakuliah/detail/forum',[DiscussionController::class,'forum'])->name('forum');
    Route::get('/matakuliah/detail/forum/{id}/messages',[DiscussionController::class,'messages'])->name('messages');
    Route::post('/matakuliah/detail/forum/{id}/messages',[DiscussionController::class,'sendMessage'])->name('messages.store');
});