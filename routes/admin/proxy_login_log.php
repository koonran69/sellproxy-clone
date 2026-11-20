<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/proxy-login-log')->controller(App\Admin\Http\Controllers\ProxyLoginLog\ProxyLoginLogController::class)
    ->name('proxy_login_log.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });
