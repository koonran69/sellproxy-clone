<?php

use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
    ->group(function () {

        //voucher
        Route::prefix('/contact')->controller(\App\Admin\Http\Controllers\Contact\ContactController::class)
            ->name('contact.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
        });
    });
