<?php

use App\Core\Enums\Setting\SettingGroup;
use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
    ->group(function () {

    //Settings
    Route::controller(App\Admin\Http\Controllers\Setting\SettingController::class)
    ->prefix('/settings')
    ->as('setting.')
    ->group(function () {

        Route::get('/index/{group}', 'index')->name('index')->whereIn('group', SettingGroup::cases());
        Route::get('/bank-account', 'bankAccount')->name('bank_account');
        Route::put('/update', 'update')->name('update');
        Route::get('/proxy-feature', 'proxyFeature')->name('proxyFeature');

    });
});
