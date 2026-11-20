<?php

namespace App\Core\Providers;

use App\Core\Facades\Utilities;
use App\Core\Facades\UtilitiFacade;
use App\Core\Responses\ResponseMacros;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class InitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
        $this->app->singleton('utilities', function ($app) {
            return new Utilities();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        ResponseMacros::register();

        // class_alias(UtilitiFacade::class, 'Utilities');

        // Facade::class_alias('utilities', UtilitiFacade::class);
    }
}