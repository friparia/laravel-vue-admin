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
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'admin');
        $this->publishes([
            __DIR__.'/../resources/assets/js' => resource_path('assets/friparia/admin'),
            __DIR__.'/../config/' => config_path(),
            __DIR__.'/../database/migrations/' => database_path('migrations'),
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
        //php artisan jwt:generate

        //$config = $this->app['config']['auth'];
        //$config["providers"]['users']['model'] = "\\Friparia\\Admin\\Models\\User";
        //$this->app['config']->set('auth', $config);
        // $this->commands([
        //     MigraBasicExampleteCommand::class,
        //     CreateAdminUserCommand::class,
        //     SetupCommand::class,
        //     PermissionCommand::class,
        // ]);
    }
}

