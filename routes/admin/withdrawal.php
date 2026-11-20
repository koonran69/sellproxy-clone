<?php

use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
    ->group(function () {

        //deposit
        Route::prefix('/withdrawal')->controller(\App\Admin\Http\Controllers\WithDrawal\WithDrawalController::class)
            ->name('withdrawal.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/accept/{id}', 'accept')->name('accept');
            Route::put('/reject/{id}', 'reject')->name('reject');
        });
    });