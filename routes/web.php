<?php

use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProxyController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('dang-ky', [AuthController::class, 'formRegister'])->name("auth.register");
Route::post('dang-ky', [AuthController::class, 'postRegister'])->name("auth.postRegister");
Route::get('dang-nhap', [AuthController::class, 'formLogin'])->name("auth.login");
Route::post('dang-nhap', [AuthController::class, 'postLogin'])->name("auth.postLogin");
Route::post('dang-xuat', [AuthController::class, 'logout'])->name("auth.logout");

Route::post('ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');

Route::get('mua-proxy', [ProxyController::class, 'listProxies'])->name("proxy.list");
Route::get('mua-proxy/{slug}', [ProxyController::class, 'proxyDetail'])->name("proxy.detail");

Route::prefix('cart')->name('cart.')->group(function () {
    Route::post('add', [CartController::class, 'addToCart'])->name('addToCart');
    Route::get('', [CartController::class, 'getCart'])->name('getCart');
    Route::post('update', [CartController::class, 'updateCartItem'])->name("updateCartItem");
    Route::post('remove', [CartController::class, 'removeFromCart'])->name("removeFromCart");
    //    Route::post('clear', [CartController::class, 'clearCart']);
});

//Route::get('giao-dich', [OrderController::class, 'checkout'])->name('order.checkout')->middleware('auth');
Route::post('order/place-order', [OrderController::class, 'placeOrder'])->name('order.place-order')->middleware('auth');
Route::get('check-status-payment', [TransactionController::class, 'checkStatusPaymentTransaction'])->name('transaction.checkStatusPayment')->middleware('auth');
Route::get('giao-dich/{code}', [TransactionController::class, 'show'])->name('transaction.show')->middleware('auth');
Route::get('change-locale/{locale}', [LocaleController::class, 'changeLocale'])->name('change-locale');

Route::get('lien-he', [ContactController::class, 'formContact'])->name('contact.form');
Route::post('lien-he', [ContactController::class, 'contactPost'])->name('contact.post');

Route::prefix('account')->middleware('auth')->name('account.')->group(function () {
    Route::get('profile', [AccountController::class, 'profile'])->name('profile');
    Route::post('profile', [AccountController::class, 'updateProfile'])->name('updateProfile');
    Route::get('reset-pass', [AccountController::class, 'resetPassForm'])->name('resetPassForm');
    Route::post('reset-pass', [AccountController::class, 'resetPass'])->name('resetPass');
    Route::get('orders', [AccountController::class, 'orders'])->name('orders');
    Route::get('wallet', [AccountController::class, 'wallet'])->name('wallet');
    Route::post('wallet', [AccountController::class, 'walletPost'])->name('walletPost');
    Route::get('history-wallet', [AccountController::class, 'walletHistory'])->name('walletHistory');
    Route::post('apply-voucher', [AccountController::class, 'apply'])->name('voucher.apply');
    Route::get('hang-thanh-vien', [AccountController::class, 'levelShow'])->name('levelShow');

    Route::get('with-drawal', [AccountController::class, 'withdrawal'])->name('withdrawal');
    Route::post('with-drawal', [AccountController::class, 'postWithdrawal'])->name('postWithdrawal');

    Route::get('danh-sach-don-hang-proxy', [AccountController::class, 'proxyLineOrder'])->name('proxyLineOrder');
    Route::get('danh-sach-proxy', [AccountController::class, 'proxyLineList'])->name('proxyLineList');
    Route::get('danh-sach-proxy/export', [AccountController::class, 'proxyLineListExport'])->name('proxyLineListExport');
    Route::post('cap-nhat-comment-proxy/{id}', [AccountController::class, 'updateComment'])->name('proxyLineList.updateComment');
});

foreach (glob(__DIR__ . '/public/*.php') as $routeFile) {
    require $routeFile;
}

Route::post('/payment/callback', [\App\Http\Controllers\CoinGateCallbackController::class, 'handleCallback']);
Route::get('/payment/success', [\App\Http\Controllers\CoinGateCallbackController::class, 'handleSuccess']);
Route::get('/payment/cancel', [\App\Http\Controllers\CoinGateCallbackController::class, 'handleCancel']);

Route::post('/auth/google', [\App\Http\Controllers\GoogleAuthController::class, 'handleGoogleLogin'])->name('auth.google');
Route::post('/coinpayments/ipn', [\App\Http\Controllers\CoinPaymentCallbackController::class, 'handleCallback']);
Route::post('/heleket/callback', [\App\Http\Controllers\HeleketCallbackController::class, 'handleCallback']);

Route::post('/vqr-payment/api/token_generate', [\App\Http\Controllers\VietQrController::class, 'tokenGenerate']);
Route::post('/vqr-payment/bank/api/transaction-sync', [\App\Http\Controllers\VietQrController::class, 'transactionSync']);

//Route::get('/gioi-thieu', [\App\Http\Controllers\PageControler::class, 'aboutPage'])->name('aboutPage');

Route::get('/quen-mat-khau', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('new-order', [\App\Http\Controllers\ProxyLineController::class, 'newOrder'])->name("proxyline.newOrder");
Route::get('order-amount', [\App\Http\Controllers\ProxyLineController::class, 'orderAmount'])->name("proxyline.orderAmount");
Route::post('pay-proxy-line', [\App\Http\Controllers\ProxyLineController::class, 'payProxyLine'])->name("proxyline.payProxyLine")->middleware('auth');

Route::get('renew-order', [\App\Http\Controllers\ProxyLineController::class, 'renewOrder'])->name("proxyline.renewOrder")->middleware('auth');
Route::get('renew-get-amount', [\App\Http\Controllers\ProxyLineController::class, 'getAmountRenew'])->name("proxyline.getAmountRenew")->middleware('auth');
Route::post('pay-renew-proxy-line', [\App\Http\Controllers\ProxyLineController::class, 'payReNewProxyLine'])->name("proxyline.payReNewProxyLine")->middleware('auth');
Route::get('ip-list', [\App\Http\Controllers\ProxyLineController::class, 'ipList'])->name("proxyline.ipList");
Route::get('json/tags', [\App\Http\Controllers\ProxyLineController::class, 'tags'])->name("proxyline.tags");

foreach (glob(__DIR__ . '/web/*.php') as $routeFile) {
    require $routeFile;
}
