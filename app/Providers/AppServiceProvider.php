<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::except([
            'payment/callback',
            'auth/google',
            'coinpayments/ipn',
            'vqr-payment/api/token_generate',
            'vqr-payment/bank/api/transaction-sync',
            'heleket/callback'
        ]);
    }
}
