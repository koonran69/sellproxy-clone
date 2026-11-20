<?php

namespace App\Providers;

use App\View\Composers\TutorialSidebar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        View::composer(
            ['public.blog.layouts.sidebar'],
            \App\View\Composers\BlogSidebar::class
        );

        View::composer(
            ['public.tutorial.layouts.sidebar'],
            TutorialSidebar::class
        );

        View::composer(
            ['public.partials.blog'],
            \App\View\Composers\Home\BlockTabPost::class
        );

    }
}
