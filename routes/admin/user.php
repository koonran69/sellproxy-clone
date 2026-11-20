<?php

use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
->group(function () {

    //Manager customer transaction
    // Route::prefix('/customer-transaction')->controller(App\Admin\Http\Controllers\Customer\TransactionController::class)
    // ->name('customer.transaction.')
    // ->group(function () {
    //     Route::get('/', 'index')->name('index');
    //     Route::get('/create', 'create')->name('create');
    //     Route::post('/store', 'store')->name('store');
    //     Route::put('/update', 'update')->name('update');
    //     Route::get('/edit/{id}', 'edit')->name('edit');
    //     Route::delete('/delete/{id}', 'delete')->name('delete');
    // });

    //Manager user
    Route::prefix('/user')->controller(App\Admin\Http\Controllers\User\UserController::class)
    ->name('user.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::put('/update', 'update')->name('update');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::get('/search-select', 'searchSelect')->name('search_select');
    });
});