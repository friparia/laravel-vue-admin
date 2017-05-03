<?php
#decrapted

namespace Friparia\RestModel;

use Route as LaravelRoute;

use Illuminate\Support\Str;

class Route extends LaravelRoute{

    /**
     * @param $model
     * @param string $name
     * @param string $classname
     * @param string $prefix
     */
    public static function admin($model, $prefix = "admin", $name = "", $classname = ''){
        if($classname == "") {
            $classname = "\\Friparia\\RestModel\\AdminController";
        }
        $instance = new $model;
        if($name == "") {
            $name = $instance->getName();
        }
        foreach($instance->getActions() as $action){
            $method = $action->method;
            $url = $prefix.'/'.$name.'/'.$action->name;
            if($action->isEach()){
                $url .= "/{id}";
            }
            self::$method($url, "\\Friparia\\RestModel\\AdminController@action")->name($model.'.'.$action->name);
        }
        self::get($prefix.'/'.$name.'/{id}', "\\Friparia\\RestModel\AdminController@index")->name($model.".show");
        self::get($prefix.'/'.$name, "\\Friparia\\RestModel\AdminController@index")->name($model.".index");
    }

}
