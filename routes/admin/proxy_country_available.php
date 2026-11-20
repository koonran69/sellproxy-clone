<?php

use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
    ->group(function () {

        //voucher
        Route::prefix('/proxy-country-available')->controller(\App\Admin\Http\Controllers\ProxyCountryAvailable\ProxyCountryAvailableController::class)
            ->name('proxy_country_available.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
                Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });
    });