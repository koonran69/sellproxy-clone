<?php

use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
    ->group(function () {

        //voucher
        Route::prefix('/proxy-residential-order')->controller(\App\Admin\Http\Controllers\ProxyResidentialOrder\ProxyResidentialOrderController::class)
            ->name('proxy_residential_order.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::get('/view/{id}', 'view')->name('view');
                Route::put('/update', 'update')->name('update');
                Route::delete('/delete/{id}', 'delete')->name('delete');
                Route::post('/proxies/change-protocol', 'changeProtocolProxy')->name('changeProtocolProxy');
                Route::get('/transaction', 'transaction')->name('transaction.index');
            });

    });
