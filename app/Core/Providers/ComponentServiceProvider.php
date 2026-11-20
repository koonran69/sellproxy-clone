<?php

namespace App\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Blade::component('core-alert', \App\Core\View\Components\Layouts\Alert::class);
        Blade::component('core-form', \App\Core\View\Components\Form::class);
        Blade::component('input', \App\Core\View\Components\Input\Input::class);
        Blade::component('input-password', \App\Core\View\Components\Input\InputPassword::class);
        Blade::component('input-email', \App\Core\View\Components\Input\InputEmail::class);
        Blade::component('input-phone', \App\Core\View\Components\Input\InputPhone::class);
        Blade::component('input-number', \App\Core\View\Components\Input\InputNumber::class);
        Blade::component('input-radio', \App\Core\View\Components\Input\InputRadio::class);
        Blade::component('input-checkbox', \App\Core\View\Components\Input\InputCheckbox::class);
        Blade::component('input-switch', \App\Core\View\Components\Input\InputSwitch::class);
        Blade::component('textarea', \App\Core\View\Components\Input\Textarea::class);
        Blade::component('select', \App\Core\View\Components\Select\Select::class);
        Blade::component('select-option', \App\Core\View\Components\Select\Option::class);
        Blade::component('input-prepended-text', \App\Core\View\Components\Input\InputPrependedText::class);

        //ckfinder
        Blade::component('input-gallery-ckfinder', \App\Core\View\Components\Input\InputGalleryCkfinder::class);
        Blade::component('input-image-ckfinder', \App\Core\View\Components\Input\InputImageCkfinder::class);
        Blade::component('input-file-ckfinder', \App\Core\View\Components\Input\InputFileCkfinder::class);
        
        Blade::component('input-filepond', \App\Core\View\Components\Input\InputFilePond::class);
    }
}