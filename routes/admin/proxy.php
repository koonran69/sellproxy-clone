<?php

use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
    ->group(function () {

        Route::prefix('/proxy')->name('proxy.')->group(function () {
            Route::controller(App\Admin\Http\Controllers\Proxy\ProxyController::class)
                ->prefix('/histories-login')
                ->name('history_login.')
                ->group(function () {
                    Route::get('/', 'historyLogin')->name('index');
                });

            Route::controller(App\Admin\Http\Controllers\Proxy\ProxyController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}/{lang?}', 'edit')->name('edit');
                Route::put('/update', 'update')->name('update');
                Route::delete('/delete/{id}', 'delete')->name('delete');
                Route::get('search-select', 'searchSelect')->name('search_select');
            });

            //category
            Route::controller(App\Admin\Http\Controllers\Proxy\CategoryController::class)
                ->prefix('/category')
                ->name('category.')
                ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}/{lang?}', 'edit')->name('edit');
                Route::put('/update', 'update')->name('update');
                Route::delete('/delete/{id}', 'delete')->name('delete');

            });

            //type
            Route::controller(App\Admin\Http\Controllers\Proxy\TypeController::class)
                ->prefix('/type')
                ->name('type.')
                ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update', 'update')->name('update');
                Route::delete('/delete/{id}', 'delete')->name('delete');

            });


            //attribute
            Route::controller(App\Admin\Http\Controllers\Proxy\AttributeController::class)
                ->prefix('/attribute')
                ->name('attribute.')
                ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update', 'update')->name('update');
                Route::delete('/delete/{id}', 'delete')->name('delete');

            });

            //variation
            Route::controller(App\Admin\Http\Controllers\Proxy\VariationController::class)
                ->prefix('/variation')
                ->name('variation.')
                ->group(function () {
                Route::get('/{attri_id}', 'index')->name('index');
                Route::get('/create/{attr_id}', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::put('/update', 'update')->name('update');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::delete('/delete/{id}', 'delete')->name('delete');
            });
        });

    });
