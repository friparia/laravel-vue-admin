<?php

namespace Friparia\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Zizaco\Entrust\EntrustServiceProvider;
use Zizaco\Entrust\EntrustFacade;
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
        // $this->app['config']['app']->register(Zizaco\Entrust\EntrustFacade::class);
        $this->loadViewsFrom(__DIR__.'/views', 'admin');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EntrustServiceProvider::class);
        $loader = AliasLoader::getInstance();
        $loader->alias("Entrust", EntrustFacade::class);
        $this->commands([
            MigrateCommand::class,
            CreateAdminUserCommand::class
        ]);
    }
}
