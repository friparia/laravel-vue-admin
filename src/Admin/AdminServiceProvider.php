<?php

namespace Friparia\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->middlewareGroup('admin', [
            \Friparia\Admin\Middleware::class,
        ]);
        $this->loadViewsFrom(__DIR__.'/../views', 'admin');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            MigrateCommand::class,
            CreateAdminUserCommand::class,
            SetupCommand::class,
        ]);
    }
}
