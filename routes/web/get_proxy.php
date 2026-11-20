<?php

use App\Http\Controllers\GetProxy\GetProxiesController;
use App\Http\Controllers\GetProxy\Abc;
use App\Http\Controllers\GetProxy\NineTwoTwo;
use App\Http\Controllers\GetProxy\Pia;
use Illuminate\Support\Facades\Route;

//Route::prefix('tao-proxy')->name('getProxies.')->group(function () {
//    Route::controller(GetProxiesController::class)->group(function () {
//        Route::redirect('/', 'tao-proxy/abcproxy')->name('index');
//    });
//
//    //ABC
//    Route::prefix('abcproxy')->name('abcproxy.')->group(function () {
//        Route::controller(Abc\DashboardController::class)->group(function () {
//            Route::get('/dashboard', 'index')->name('index');
//            Route::post('connect', 'connect')->name('connect');
//            Route::post('refresh', 'refresh')->name('refresh');
//            Route::get('logout', 'logout')->name('logout');
//        });
//
//        Route::prefix('sub-accounts')->name('subAccounts.')->controller(Abc\SubAccountController::class)->group(function () {
//            Route::get('/', 'index')->name('index');
//            Route::post('add', 'add')->name('add');
//            Route::post('toggle', 'toggle')->name('toggle');
//            Route::post('delete', 'delete')->name('delete');
//            Route::post('update', 'update')->name('update');
//        });
//
//        Route::prefix('cdk')->name('cdk.')->controller(Abc\CdkController::class)->group(function () {
//            Route::get('/list', 'index')->name('list');
//            Route::post('/generate', 'generate')->name('generate');
//            Route::post('/exchange', 'exchange')->name('exchange');
//        });
//
//        Route::prefix('use-proxy')->name('useProxy.')->controller(Abc\UseProxyController::class)->group(function () {
//            Route::get('/data', 'index')->name('data');
//        });
//
//        Route::prefix('whitelist')->name('whitelist.')->controller(Abc\WhitelistController::class)->group(function () {
//            Route::post('/list', 'list')->name('list');
//            Route::post('/add', 'add')->name('add');
//            Route::post('/lock', 'lock')->name('lock');
//            Route::post('/delete', 'delete')->name('delete');
//            Route::get('/proxy-info', 'proxyInfo')->name('proxyInfo');
//        });
//    });
//
//    // 922
//    Route::prefix('922proxy')->name('nicetwotwoproxy.')->group(function () {
//        Route::controller(NineTwoTwo\DashboardController::class)->group(function () {
//            Route::get('/dashboard', 'index')->name('index');
//            Route::post('connect', 'connect')->name('connect');
//            Route::post('refresh', 'refresh')->name('refresh');
//            Route::get('logout', 'logout')->name('logout');
//        });
//
//        Route::prefix('sub-accounts')->name('subAccounts.')->controller(NineTwoTwo\SubAccountController::class)->group(function () {
//            Route::get('/', 'index')->name('index');
//            Route::post('add', 'add')->name('add');
//            Route::post('delete', 'delete')->name('delete');
//            Route::post('update', 'update')->name('update');
//        });
//
//        Route::prefix('cdk')->name('cdk.')->controller(NineTwoTwo\CdkController::class)->group(function () {
//            Route::get('/list', 'index')->name('list');
//            Route::post('/generate', 'generate')->name('generate');
//            Route::post('/exchange', 'exchange')->name('exchange');
//        });
//
//        Route::prefix('use-proxy')->name('useProxy.')->controller(NineTwoTwo\UseProxyController::class)->group(function () {
//            Route::get('/data', 'index')->name('data');
//        });
//    });
//
//    // Pia
//    Route::prefix('piaproxy')->name('piaproxy.')->group(function () {
//        Route::controller(Pia\DashboardController::class)->group(function () {
//            Route::get('/dashboard', 'index')->name('index');
//            Route::post('connect', 'connect')->name('connect');
//            Route::post('refresh', 'refresh')->name('refresh');
//            Route::get('logout', 'logout')->name('logout');
//        });
//
//        Route::prefix('sub-accounts')->name('subAccounts.')->controller(Pia\SubAccountController::class)->group(function () {
//            Route::get('/', 'index')->name('index');
//        });
//
//        Route::prefix('cdk')->name('cdk.')->controller(Pia\CdkController::class)->group(function () {
//            Route::get('/list', 'index')->name('list');
//            Route::post('/generate', 'generate')->name('generate');
//            Route::post('/exchange', 'exchange')->name('exchange');
//        });
//
//        Route::prefix('use-proxy')->name('useProxy.')->controller(Pia\UseProxyController::class)->group(function () {
//            Route::get('/data', 'index')->name('data');
//        });
//    });
//
//    Route::controller(GetProxiesController::class)->group(function () {
//        Route::get('{slug}', 'index')->name('show');
//    });
//});
