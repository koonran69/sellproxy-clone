<?php

use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
    ->group(function () {

        //voucher
        Route::prefix('/cdkey')->controller(\App\Admin\Http\Controllers\CdKey\CdKeyController::class)
            ->name('cdkey.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
            Route::get('/get-variation-by-proxy', 'getVariationByProxy')->name('getVariationByProxy');
            Route::post('/import', 'import')->name('import');

            });
    });
