<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\Tutorial\BlogController::class)
->prefix('/huong-dan')
->name('tutorial.')
->group(function() {

    Route::get('/', 'index')->name('index');

    Route::controller(\App\Http\Controllers\Tutorial\CategoryController::class)
    ->prefix('/chuyen-muc')
    ->name('category.')
    ->group(function() {
        Route::get('/{slug}', 'show')->name('show')->where('slug', '[a-z0-9-]+');
    });
    
    Route::controller(\App\Http\Controllers\Tutorial\PostController::class)
    ->prefix('/bai-viet')
    ->name('post.')
    ->group(function() {
        Route::get('/{slug}', 'show')->name('show')->where('slug', '[a-z0-9-]+');
    });

});
