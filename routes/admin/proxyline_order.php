<?php

use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
    ->group(function () {

        //voucher
        Route::prefix('/proxyline-order')->controller(\App\Admin\Http\Controllers\ProxylineOrder\ProxylineOrderController::class)
            ->name('proxyline_order.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::put('/update', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });
    });