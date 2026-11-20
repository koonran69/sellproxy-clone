<?php

use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
->group(function () {
    
    Route::get('/', function () {
        return to_route('admin.dashboard');
    })->name('home');

    Route::get('/dashboard', [App\Admin\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard');

    //Manager admin
    Route::prefix('/admin')->controller(App\Admin\Http\Controllers\Admin\AdminController::class)
    ->name('admin.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::put('/update', 'update')->name('update');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });

    //ckfinder
    Route::prefix('/manager-file')->name('ckfinder.')->group(function(){
        Route::any('/connect', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
        ->name('connector');
        Route::any('/duyet', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
        ->name('browser');
    });

});

foreach (glob(__DIR__.'/admin/*.php') as $routeFile) {
    require $routeFile;
}
