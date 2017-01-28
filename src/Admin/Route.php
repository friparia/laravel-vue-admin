<?php

namespace Friparia\Admin;

use Route as LaravelRoute;

use Illuminate\Support\Str;

class Route{
    public static function admin($controller, $name = "", $prefix = 'admin'){

        if($name == "") {
            $name = Str::snake(class_basename($controller));
        }
        LaravelRoute::group(['middleware' => ['web', 'admin']], function () use ($prefix, $name, $controller) {
            LaravelRoute::get($prefix . '/' . $name . '/{action}/{id?}', '\\'.$controller . '@index');
            LaravelRoute::post($prefix . '/' . $name . '/{action}/{id?}', '\\'.$controller . '@index');
        });
    }

    public static function init($prefix = 'admin'){
        Route::admin(Controllers\UserController::class, 'user');
        Route::admin(Controllers\RoleController::class, 'role');
        Route::admin(Controllers\LogController::class, 'log');
        Route::admin(Controllers\FeedbackController::class, 'feedback');
        Route::admin(Controllers\MessageController::class, 'message');
        LaravelRoute::group(['middleware' => 'web'], function() use ($prefix) {
            LaravelRoute::get($prefix.'/auth/login', '\Friparia\Admin\Controllers\AuthController@login')->name('admin.login');
            LaravelRoute::post($prefix.'/auth/login', '\Friparia\Admin\Controllers\AuthController@dologin')->name('admin.dologin');
            LaravelRoute::get($prefix.'/auth/logout', '\Friparia\Admin\Controllers\AuthController@logout')->name('admin.logout');
            LaravelRoute::get($prefix.'/auth/forget', '\Friparia\Admin\Controllers\AuthController@forget')->name('admin.forget');
            LaravelRoute::post($prefix.'/auth/change-password', '\Friparia\Admin\Controllers\AuthController@changePassword')->name('admin.change');
            LaravelRoute::get($prefix.'/auth/captcha/{username}', '\Friparia\Admin\Controllers\AuthController@captcha')->name('admin.change');
            LaravelRoute::group(['middleware' => ['admin']], function () use ($prefix) {
                LaravelRoute::get($prefix . '/',  '\Friparia\Admin\Controllers\AdminController@index')->name('admin.index');
                LaravelRoute::get($prefix.'/data', '\Friparia\Admin\Controllers\DataController@index');
                LaravelRoute::get($prefix.'/data/export', '\Friparia\Admin\Controllers\DataController@export');
            });
        });
    }

    /**
     * @param $model
     * @param string $name
     * @param string $classname
     * @param string $prefix
     */
    public static function api($model, $name = "", $classname = "", $prefix = 'api'){
        if($name == "") {
            $name = Str::snake(class_basename($model));
        }
        if($classname == "") {
            $classname = ucfirst(Str::camle($name . "Controller"));
        }
        LaravelRoute::get($prefix.'/'.$name, $classname.'@apiList');
        LaravelRoute::get($prefix.'/'.$name.'/show/{id}' , $classname.'@apiShow');
        LaravelRoute::get($prefix.'/'.$name.'/{action}/{id?}', $classname.'@api');
        LaravelRoute::post($prefix.'/'.$name.'/{action}/{id?}', $classname.'@api');
    }

}
