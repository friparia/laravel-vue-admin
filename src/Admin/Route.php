<?php

namespace Friparia\Admin;

use Route as LaravelRoute;

use Illuminate\Support\Str;

class Route{
    public static function admin($model, $name = "", $classname = "", $prefix = 'admin'){
        if($name == "") {
            $name = Str::snake(class_basename($model));
        }
        if($classname == "") {
            $classname = ucfirst($name) . "Controller";
        }
        LaravelRoute::group(['middleware' => 'web'], function() use ($prefix, $name, $classname) {
            LaravelRoute::get($prefix.'/auth/login', '\Friparia\Admin\AuthController@login')->name('admin.login');
            LaravelRoute::post($prefix.'/auth/login', '\Friparia\Admin\AuthController@dologin')->name('admin.dologin');
            LaravelRoute::get($prefix.'/auth/logout', '\Friparia\Admin\AuthController@logout')->name('admin.logout');
            LaravelRoute::group(['middleware' => ['admin']], function () use ($prefix, $name, $classname) {
                LaravelRoute::get($prefix . '/',  '\Friparia\Admin\AdminController@dashboard');
                LaravelRoute::get($prefix.'/'.$name, $classname.'@adminList');
                LaravelRoute::get($prefix.'/'.$name.'/show/{id}' , $classname.'@adminShow');
                LaravelRoute::get($prefix . '/' . $name . '/{action}/{id?}', $classname . '@admin');
                LaravelRoute::post($prefix . '/' . $name . '/{action}/{id?}', $classname . '@admin');
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
            $classname = ucfirst($name) . "Controller";
        }
        LaravelRoute::get($prefix.'/'.$name, $classname.'@apiList');
        LaravelRoute::get($prefix.'/'.$name.'/show/{id}' , $classname.'@apiShow');
        LaravelRoute::get($prefix.'/'.$name.'/{action}/{id?}', $classname.'@api');
        LaravelRoute::post($prefix.'/'.$name.'/{action}/{id?}', $classname.'@api');
    }

}
