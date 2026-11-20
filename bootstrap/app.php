<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('/admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->encryptCookies(except: [
            'ckCsrfToken'
        ]);

        $middleware->validateCsrfTokens(except: [
            'ckfinder/*',
            'admin/manager-file/*'
        ]);

        $middleware->web(append: [
            SetLocale::class,
        ]);

        $middleware->redirectGuestsTo('/dang-nhap');
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
