<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProxyHomeController;

Route::get('proxies/free-rotate', [ProxyHomeController::class, 'freeRotate'])->name('proxyhome_free_rotate');

Route::prefix('proxy-home')->name('proxyhome.')->group(function () {

    Route::get('proxy-tinh', [ProxyHomeController::class, 'proxyStaticList'])->name('proxyStaticList');
    Route::get('proxy-xoay', [ProxyHomeController::class, 'proxyRotateList'])->name('proxyRotateList');

    Route::get('key-xoay', [ProxyHomeController::class, 'keyRotateList'])->name('keyRotateList');
    Route::get('proxy-datacenter', [ProxyHomeController::class, 'proxyDatacenterList'])->name('proxyDatacenterList');
    Route::get('combo-proxy', [ProxyHomeController::class, 'comboProxyList'])->name('comboProxyList');

    Route::middleware('auth')->group(function() {
        Route::get('proxies', [ProxyHomeController::class, 'listProxies'])->name('listProxies');
        Route::get('proxies/rotate', [ProxyHomeController::class, 'listRotateProxies'])->name('listRotateProxies');
        Route::post('proxy-tinh/orders', [ProxyHomeController::class, 'proxyStaticOrder'])->name('proxyStaticOrder');

        Route::get('key-xoay/list', [ProxyHomeController::class, 'listKeyRotate'])->name('listKeyRotate');
        Route::post('key-xoay/order', [ProxyHomeController::class, 'submitKeyRotateOrder'])->name('submitKeyRotateOrder');
        Route::get('key-xoay/generate-token/{partner_item_id}', [ProxyHomeController::class, 'generateTokenKeyRotate'])->name('generateTokenKeyRotate');

        Route::post('proxy-datacenter/order', [ProxyHomeController::class, 'submitProxyDatacenterOrder'])->name('submitProxyDatacenterOrder');
        Route::get('proxy-datacenter/list', [ProxyHomeController::class, 'listProxyDatacenter'])->name('listProxyDatacenter');

        Route::post('combo-proxy/order', [ProxyHomeController::class, 'submitComboOrder'])->name('submitComboOrder');

        Route::post('proxy-xoay/orders', [ProxyHomeController::class, 'proxyRotateOrder'])->name('proxyRotateOrder');
        Route::get('proxies/search', [ProxyHomeController::class, 'searchProxies'])->name('searchProxies');
        Route::get('proxies/rotate/search', [ProxyHomeController::class, 'searchRotateProxies'])->name('searchRotateProxies');
        Route::post('proxies/bulk-change-password', [ProxyHomeController::class, 'bulkChangePassword'])->name('bulkChangePassword');
        Route::post('proxies/xoay/bulk-change-password', [ProxyHomeController::class, 'bulkChangePasswordRotate'])->name('bulkChangePasswordRotate');
        Route::get('proxies/xoay/rotate', [ProxyHomeController::class, 'actionRotate'])->name('actionRotate');
        Route::get('proxies/xoay/sync', [ProxyHomeController::class, 'sync'])->name('sync');
        Route::post('proxies/renew', [ProxyHomeController::class, 'bulkRenew'])->name('bulkRenew');
        Route::post('proxies/bulk-protocal', [ProxyHomeController::class, 'bulkProtocal'])->name('bulkProtocal');
        Route::get('proxy-tinh/xuat', [ProxyHomeController::class, 'exportProxyStatic'])->name('exportProxyStatic');
        Route::get('proxy-xoay/xuat', [ProxyHomeController::class, 'exportProxyRotate'])->name('exportProxyRotate');
        Route::get('proxy-order', [ProxyHomeController::class, 'listProxyOrders'])->name('listProxyOrders');
        Route::get('proxy-order/search', [ProxyHomeController::class, 'searchProxyOrders'])->name('searchProxyOrders');
        Route::get('transaction', [ProxyHomeController::class, 'transactionHistory'])->name('transactionHistory');
        Route::get('transaction/search', [ProxyHomeController::class, 'searchTransactionHistory'])->name('searchTransactionHistory');

        Route::get('handle-sync-proxies-for-order', [ProxyHomeController::class, 'handleSyncProxiesForOrder']);
    });
});
