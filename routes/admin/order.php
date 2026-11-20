<?php

use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
    ->group(function () {

        //order
        Route::prefix('/order')->controller(App\Admin\Http\Controllers\Order\OrderController::class)
            ->name('order.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');

            Route::get('/render-info-user', 'renderInfoUser')->name('render_info_user');

            Route::get('/render-product', 'searchRenderProduct')->name('search.render_product');
            Route::get('/add-product', 'addProduct')->name('add_product');
        });
    });