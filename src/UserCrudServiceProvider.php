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
        $this->loadViewsFrom(
            __DIR__.'/views', 'user',
        );

        $this->loadRoutesFrom(
            __DIR__.'/routes/web.php'
        );
        
        $this->publishes([
            __DIR__.'/public/js/controllers' => public_path('js/controllers'),
            __DIR__.'/views/layouts' => resource_path('views/layouts'),
            /*__DIR__.'/Controllers' => app_path('Http/Controllers'),
            __DIR__.'/Models' => app_path('/'),*/
        ], 'users-crud');
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
