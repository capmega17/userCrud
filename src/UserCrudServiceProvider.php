<?php

namespace Capmega\UserCRUD;

use Illuminate\Support\ServiceProvider;

class UserCrudServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/../public/js/controllers' => public_path('js/controllers'),], 'users');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'users');
        $this->publishes([__DIR__.'/../resources/views' => resource_path('views/users'),], 'users');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // register our controller
    }
}
