<?php

return [
    //core
    App\Core\Providers\InitServiceProvider::class,
    App\Core\Providers\ComponentServiceProvider::class,
    App\Core\Providers\RepositoryServiceProvider::class,

    //default
    App\Providers\AppServiceProvider::class,
    App\Providers\ObServiceProvider::class,
    App\Providers\ViewServiceProvider::class,

    //admin
    App\Admin\Providers\ComponentServiceProvider::class,
    App\Admin\Providers\RepositoryServiceProvider::class,
    App\Admin\Providers\ExtendBladeServiceProvider::class,
];
