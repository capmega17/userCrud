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
            __DIR__.'/resources/views', 'users'
        );

        //Routes 
        $this->registerRoutes();
        
        $this->publishes([
            __DIR__.'/public/js/controllers' => public_path('js/controllers'),
            __DIR__.'/resources/views' => resource_path('views/'),
            __DIR__.'/Controllers' => app_path('Http/Controllers'),
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

    /**
     * Register Routes.
     *
     */
    protected function registerRoutes(): void
    {
        require_once __DIR__ . '/routes/web.php';
    }
}
