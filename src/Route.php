<?php

namespace Friparia\Admin;

use Route as LaravelRoute;
use Illuminate\Support\Str;

class Route{
    public static function admin($model, $prefix = 'admin'){
        $name = Str::snake(class_basename($model));
        $classname = ucfirst($name)."Controller";

        LaravelRoute::get($prefix.'/'.$name.'/{action}/{id?}', $classname.'@index');
        LaravelRoute::post($prefix.'/'.$name.'/{action}/{id?}', $classname.'@index');
    }

    public static function api($model, $prefix = 'api'){
        $name = Str::snake(class_basename($model));
        $classname = ucfirst($name)."Controller";

        LaravelRoute::get($prefix.'/'.$name, $classname.'@apiList');
        LaravelRoute::get($prefix.'/'.$name.'/{action}/{id?}', $classname.'@api');
        LaravelRoute::post($prefix.'/'.$name.'/{action}/{id?}', $classname.'@api');
        LaravelRoute::get($prefix.'/'.$name.'/{id}' , $classname.'@apiShow');
    }

}
