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
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->publishes([
            __DIR__.'/resources/views/user' => resource_path('views/user/'),
        ]);
        $this->publishes([
            __DIR__.'/resources/views/user/partials' => resource_path('views/user/partials/'),
        ]);
        $this->publishes([
            __DIR__.'/resources/views/layouts' => resource_path('views/layouts/'),
        ]);
        $this->publishes([
            __DIR__.'/public/js/controllers/' => public_path('js/controllers/'),
        ], 'public');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // register our controller
        $this->app->make('app\Http\Controllers\UserController');
        $this->loadViewsFrom(__DIR__.'/resources/views/user', 'get');
    }
}
