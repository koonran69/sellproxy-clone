<?php

use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
    ->group(function () {

        //transaction
        Route::prefix('/transaction')->controller(App\Admin\Http\Controllers\Transaction\TransactionController::class)
        ->name('transaction.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });

    });
