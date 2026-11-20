<?php

use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
    ->group(function () {

        Route::prefix('/homeproxy')->controller(\App\Admin\Http\Controllers\HomeProxy\HomeProxyController::class)
            ->name('homeproxy.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/charge', 'charge')->name('charge');
                Route::post('/handle-charge', 'handleCharge')->name('handle_charge');

                Route::post('/generate-token/{id}', 'generateTokenKeyRotate')->name('generate_token');
                Route::get('handle-sync-proxies-for-order', 'handleSyncProxiesForOrder')->name('handleSyncProxiesForOrder');
            });

        Route::prefix('/homeproxy/transaction')->controller(\App\Admin\Http\Controllers\HomeProxy\HomeProxyTransactionController::class)
            ->name('homeproxy.transaction.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
            });
    });
