<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VPSController;

Route::prefix('vps')->name('vps.')->group(function () {
    Route::get('proxy-tinh', [VPSController::class, 'proxyStaticList'])->name('proxyStaticList');
    Route::get('/ajax-service-detail', [VPSController::class, 'ajaxServiceDetail'])->name('ajaxServiceDetail');
    Route::get('/ajax-period-extension-price', [VPSController::class, 'ajaxPeriodExtensionPrice'])->name('ajaxPeriodExtensionPrice');

    Route::get('buying', [VPSController::class, 'buying'])->name('buying');
    Route::get('buying-gpu', [VPSController::class, 'buyingGPU'])->name('buyingGPU');
    Route::get('ajax-support', [VPSController::class, 'ajaxSupport'])->name('ajaxSupport');
    Route::post('ajax-calculate', [VPSController::class, 'ajaxCalculate'])->name('ajaxCalculate');

    Route::prefix('proxy')->name('proxy.')->group(function () {
        Route::get('buy-proxy', [VPSController::class, 'getProxyOrderBuy'])->name('getProxyOrderBuy');
        Route::get('ajax-support', [VPSController::class, 'ajaxProxySupport'])->name('ajaxProxySupport');
        Route::post('ajax-calculate', [VPSController::class, 'ajaxProxyCalculate'])->name('ajaxProxyCalculate');
    });

    Route::middleware('auth')->group(function() {
        Route::get('buying-order', [VPSController::class, 'buyingOrder'])->name('buyingOrder');
        Route::get('buying-order-gpu', [VPSController::class, 'buyingOrderGPU'])->name('buyingOrderGPU');
        Route::post('make-orders', [VPSController::class, 'makeOrder'])->name('makeOrder');
        Route::get('transaction', [VPSController::class, 'transactionHistory'])->name('transactionHistory');
        Route::get('transaction/search', [VPSController::class, 'searchTransactionHistory'])->name('searchTransactionHistory');
        Route::get('vps-order', [VPSController::class, 'listVpsOrders'])->name('listVpsOrders');
        Route::get('vps-order/search', [VPSController::class, 'searchVpsOrders'])->name('searchVpsOrders');
        Route::get('vps-management', [VPSController::class, 'listVpsManagement'])->name('listVpsManagement');
        Route::get('vps-management/search', [VPSController::class, 'searchVpsManagement'])->name('searchVpsManagement');
        Route::post('ajax-auto-extend', [VPSController::class, 'ajaxAutoExtend'])->name('ajaxAutoExtend');
        Route::post('ajax-get-upgrade-plan', [VPSController::class, 'ajaxGetUpgradePlan'])->name('ajaxGetUpgradePlan');
        Route::post('ajax-upgrade-calculate', [VPSController::class, 'ajaxUpgradeVPSCalculate'])->name('ajaxUpgradeVPSCalculate');
        Route::post('upgrade-vps', [VPSController::class, 'upgradeVPS'])->name('upgradeVPS');
        Route::post('ajax-get-change-ip', [VPSController::class, 'ajaxGetChangeIP'])->name('ajaxGetChangeIP');
        Route::post('change-ip', [VPSController::class, 'changeIP'])->name('changeIP');
        Route::post('confirm-action', [VPSController::class, 'confirmAction'])->name('confirmAction');
        Route::post('ajax-renew-calculate', [VPSController::class, 'ajaxRenewCalculate'])->name('ajaxRenewCalculate');
        Route::post('renew-vps', [VPSController::class, 'renewVPS'])->name('renewVPS');
        Route::get('ajax-support-os', [VPSController::class, 'ajaxGetSupportOS'])->name('ajaxGetSupportOS');
        Route::post('re-setting-vps', [VPSController::class, 'reSettingVPS'])->name('reSettingVPS');
        Route::get('export', [VPSController::class, 'exportVPS'])->name('exportVPS');

        Route::prefix('proxy')->name('proxy.')->group(function () {
            Route::post('make-orders-proxy', [VPSController::class, 'makeOrderProxy'])->name('makeOrderProxy');
            Route::get('transaction', [VPSController::class, 'transactionProxyHistory'])->name('transactionProxyHistory');
            Route::get('transaction/search', [VPSController::class, 'searchTransactionProxyHistory'])->name('searchTransactionProxyHistory');
            Route::get('order', [VPSController::class, 'listProxyOrders'])->name('listProxyOrders');
            Route::get('order/search', [VPSController::class, 'searchProxyOrders'])->name('searchProxyOrders');
            Route::get('management', [VPSController::class, 'listProxyManagement'])->name('listProxyManagement');
            Route::get('management/search', [VPSController::class, 'searchProxyManagement'])->name('searchProxyManagement');

            Route::get('export', [VPSController::class, 'exportProxy'])->name('exportProxy');
            Route::post('re-setting-vps', [VPSController::class, 'reSettingProxy'])->name('reSettingProxy');
            Route::post('ajax-renew-calculate', [VPSController::class, 'ajaxRenewCalculateProxy'])->name('ajaxRenewCalculateProxy');
            Route::post('renew', [VPSController::class, 'renewProxy'])->name('renewProxy');
            Route::post('change-ip', [VPSController::class, 'changeIPProxy'])->name('changeIPProxy');
            Route::post('ajax-get-change-ip', [VPSController::class, 'ajaxGetChangeIPProxy'])->name('ajaxGetChangeIPProxy');
            Route::post('confirm-action', [VPSController::class, 'confirmActionProxy'])->name('confirmActionProxy');
            Route::post('ajax-auto-extend', [VPSController::class, 'ajaxAutoExtendProxy'])->name('ajaxAutoExtendProxy');
        });
    });
});
