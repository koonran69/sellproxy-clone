<?php

use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
    ->group(function () {

        Route::prefix('/vps')->controller(\App\Admin\Http\Controllers\Vps\VpsController::class)
            ->name('vps.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/view/{id}', 'view')->name('view');

            Route::get('/transaction', 'transaction')->name('transaction.index');

            Route::prefix('/proxy')->controller(\App\Admin\Http\Controllers\Vps\VpsController::class)
                ->name('proxy.')
                ->group(function () {
                    Route::get('/', 'indexProxy')->name('indexProxy');
                    Route::get('/view/{id}', 'viewProxy')->name('viewProxy');

                    Route::get('/transaction', 'transactionProxy')->name('transactionProxy.index');
                });
        });
    });
