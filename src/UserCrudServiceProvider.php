<?php

namespace Capmega\UserCrud;

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
        $this->publishes([__DIR__.'/../resources/views' => resource_path('views/'),], 'users');
        include __DIR__.’/routes.php’;
        $this->publishes([__DIR__.'/Controllers' => app_path('Http/Controllers'),
    ]);
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
