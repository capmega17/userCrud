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
        $this->publishes([__DIR__.'/../src/public/js/controllers/' => public_path('src/public/js/controllers'),], 'public');
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
