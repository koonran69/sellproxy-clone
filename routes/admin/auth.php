<?php

use Illuminate\Support\Facades\Route;

Route::middleware(App\Admin\Http\Middleware\GuestAdminMiddleware::class)->group(function () {
    
    Route::controller(App\Admin\Http\Controllers\Auth\LoginController::class)
    ->prefix('/login')
    ->name('login.')
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'handle')->name('handle');
    });
});

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
->group(function () {

    //auth
    Route::controller(App\Admin\Http\Controllers\Auth\ProfileController::class)
    ->prefix('/profile')
    ->name('profile.')
    ->group(function(){
        Route::get('/', 'index')->name('index');
        Route::put('/', 'update')->name('update');
    });

    Route::controller(App\Admin\Http\Controllers\Auth\ChangePasswordController::class)
    ->prefix('/password')
    ->name('password.')
    ->group(function(){
        Route::get('/', 'index')->name('change');
        Route::put('/', 'update')->name('update');
    });

    Route::post('/logout', [App\Admin\Http\Controllers\Auth\LogoutController::class, 'logout'])->name('logout');
});
