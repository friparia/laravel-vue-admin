<?php

namespace Friparia\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;
use Friparia\Admin\CreateAdminUserCommand;
use Friparia\Admin\MigrateCommand;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'admin');
        $this->publishes([
            __DIR__.'/../resources/assets/js' => resource_path('assets/friparia/admin'),
            __DIR__.'/../config/' => config_path(),
            __DIR__.'/../migrations/' => database_path('migrations'),
        ]);
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register("Tymon\JWTAuth\Providers\JWTAuthServiceProvider");
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('JWTAuth', 'Tymon\JWTAuth\Facades\JWTAuth');
        $this->commands([
            CreateAdminUserCommand::class,
            MigrateCommand::class,
        ]);
    }
}

