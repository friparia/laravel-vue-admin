<?php

namespace Friparia\Admin;

use Route as LaravelRoute;

use Illuminate\Support\Str;

class Route{
    public static function admin($model, $prefix = 'admin'){
        $name = Str::snake(class_basename($model));
        $classname = ucfirst($name)."Controller";
        LaravelRoute::group(['middleware' => 'web'], function() use ($prefix, $name, $classname) {
            LaravelRoute::get($prefix.'/auth/login', '\Friparia\Admin\AuthController@login')->name('admin.login');
            LaravelRoute::post($prefix.'/auth/login', '\Friparia\Admin\AuthController@dologin')->name('admin.dologin');
            LaravelRoute::get($prefix.'/auth/logout', '\Friparia\Admin\AuthController@logout')->name('admin.logout');
            LaravelRoute::group(['middleware' => ['admin']], function () use ($prefix, $name, $classname) {
                LaravelRoute::get($prefix . '/', $classname . '@adminIndex');
                LaravelRoute::get($prefix . '/' . $name . '/{action}/{id?}', $classname . '@admin');
                LaravelRoute::post($prefix . '/' . $name . '/{action}/{id?}', $classname . '@admin');
            });
        });
    }

    public static function api($model, $prefix = 'api'){
        $name = Str::snake(class_basename($model));
        $classname = ucfirst($name)."Controller";
        LaravelRoute::get($prefix.'/'.$name, $classname.'@apiList');
        LaravelRoute::get($prefix.'/'.$name.'/show/{id}' , $classname.'@apiShow');
        LaravelRoute::get($prefix.'/'.$name.'/{action}/{id?}', $classname.'@api');
        LaravelRoute::post($prefix.'/'.$name.'/{action}/{id?}', $classname.'@api');
    }

}
