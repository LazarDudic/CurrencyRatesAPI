<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ValidateFacadesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        app()->bind('validate', function(){
            return new \App\Validation\Validate();
        });
    }
}
