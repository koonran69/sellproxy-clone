<?php

use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\Blog\BlogController::class)
->prefix('/blog')
->name('blog.')
->group(function() {

    Route::get('/', 'index')->name('index');

    Route::controller(App\Http\Controllers\Blog\CategoryController::class)
    ->prefix('/chuyen-muc')
    ->name('category.')
    ->group(function() {
        Route::get('/{slug}', 'show')->name('show')->where('slug', '[a-z0-9-]+');
    });
    
    Route::controller(App\Http\Controllers\Blog\PostController::class)
    ->prefix('/bai-viet')
    ->name('post.')
    ->group(function() {
        Route::get('/{slug}', 'show')->name('show')->where('slug', '[a-z0-9-]+');
    });

});
