<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProxyResidentialController;

Route::prefix('proxies/residential')->name('proxyResidential.')->group(function () {
    Route::get('proxy-tinh', [ProxyResidentialController::class, 'proxyStaticList'])->name('proxyStaticList');
    Route::post('/proxy-tinh/get-price', [ProxyResidentialController::class, 'proxyGetPrice'])->name('proxyGetPrice');

    Route::get('/ajax-service-detail', [ProxyResidentialController::class, 'ajaxServiceDetail'])->name('ajaxServiceDetail');
    Route::get('/ajax-period-extension-price', [ProxyResidentialController::class, 'ajaxPeriodExtensionPrice'])->name('ajaxPeriodExtensionPrice');


    Route::middleware('auth')->group(function() {
        Route::post('proxy-tinh/orders', [ProxyResidentialController::class, 'proxyMakeOrder'])->name('proxyMakeOrder');
        Route::get('proxies', [ProxyResidentialController::class, 'listProxies'])->name('listProxies');
        Route::get('proxy-order', [ProxyResidentialController::class, 'listProxyOrders'])->name('listProxyOrders');
        Route::get('proxy-order/search', [ProxyResidentialController::class, 'searchProxyOrders'])->name('searchProxyOrders');
        Route::get('transaction', [ProxyResidentialController::class, 'transactionHistory'])->name('transactionHistory');
        Route::get('transaction/search', [ProxyResidentialController::class, 'searchTransactionHistory'])->name('searchTransactionHistory');
        Route::get('proxies/search', [ProxyResidentialController::class, 'searchProxies'])->name('searchProxies');
        Route::get('proxies/xoay/sync', [ProxyResidentialController::class, 'sync'])->name('sync');
        Route::post('proxies/change-auth', [ProxyResidentialController::class, 'changeAuthProxy'])->name('changeAuthProxy');
        Route::post('proxies/change-protocol', [ProxyResidentialController::class, 'changeProtocolProxy'])->name('changeProtocolProxy');
        Route::post('proxies/change-note', [ProxyResidentialController::class, 'changeNoteProxy'])->name('changeNoteProxy');

        Route::post('proxies/extend-proxy', [ProxyResidentialController::class, 'extendProxy'])->name('extendProxy');
        Route::get('proxy-tinh/xuat', [ProxyResidentialController::class, 'exportProxyStatic'])->name('exportProxyStatic');

        Route::post('proxy-xoay/orders', [ProxyResidentialController::class, 'proxyRotateOrder'])->name('proxyRotateOrder');
        Route::get('proxies/rotate/search', [ProxyResidentialController::class, 'searchRotateProxies'])->name('searchRotateProxies');
        Route::get('proxies/xoay/rotate', [ProxyResidentialController::class, 'actionRotate'])->name('actionRotate');
        Route::post('proxies/renew', [ProxyResidentialController::class, 'bulkRenew'])->name('bulkRenew');
        Route::post('proxies/bulk-protocal', [ProxyResidentialController::class, 'bulkProtocal'])->name('bulkProtocal');
         });
});
