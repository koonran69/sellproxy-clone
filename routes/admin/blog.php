<?php

use Illuminate\Support\Facades\Route;

// Authented Admin routes
Route::middleware([App\Admin\Http\Middleware\AuthAdminMiddleware::class, App\Admin\Http\Middleware\AccessRouteNameMiddleware::class])
->group(function () {

    Route::prefix('/blog')->name('blog.')->group(function () {
        //Post category
        Route::controller(App\Admin\Http\Controllers\Blog\Category\CategoryController::class)
        ->prefix('/categories')
        ->name('category.')
        ->group(function () {
            Route::get('/add', 'create')->name('create');
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}/{lang?}', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
            Route::post('/store', 'store')->name('store');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });

        //Post
        Route::controller(App\Admin\Http\Controllers\Blog\Post\PostController::class)
        ->prefix('/posts')
        ->name('post.')
        ->group(function () {
                Route::get('/add', 'create')->name('create');
                Route::get('/', 'index')->name('index');
                Route::get('/edit/{id}/{lang?}', 'edit')->name('edit');
                Route::put('/update', 'update')->name('update');
                Route::post('/store', 'store')->name('store');
                Route::delete('/delete/{id}', 'delete')->name('delete');
                Route::post('/action-multile-record', 'actionMultipleRecode')->name('action_multiple_record');
        });
    });
});
