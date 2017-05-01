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
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../Admin/routes.php';
        }
        $this->publishes([
            __DIR__.'/../resources/assets/' => public_path(),
            __DIR__.'/../config/' => config_path(),
            __DIR__.'/../resources/views' => resource_path('views/admin'),
        ]);
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
            // PermissionCommand::class,
        ]);
    }
}

