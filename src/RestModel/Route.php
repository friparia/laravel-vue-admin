<?php
#decrapted

namespace Friparia\RestModel;

use Route as LaravelRoute;

use Illuminate\Support\Str;

class Route extends LaravelRoute{
    // public static function admin($controller, $name = "", $prefix = 'admin'){
    //
    //     if($name == "") {
    //         $name = Str::snake(class_basename($controller));
    //     }
    //     LaravelRoute::group(['middleware' => ['web', 'admin']], function () use ($prefix, $name, $controller) {
    //         LaravelRoute::get($prefix . '/' . $name . '/{action}/{id?}', '\\'.$controller . '@index');
    //         LaravelRoute::post($prefix . '/' . $name . '/{action}/{id?}', '\\'.$controller . '@index');
    //     });
    // }
    //
    // public static function init($prefix = 'admin'){
    //     Route::admin(Controllers\UserController::class, 'user');
    //     Route::admin(Controllers\RoleController::class, 'role');
    //     Route::admin(Controllers\LogController::class, 'log');
    //     Route::admin(Controllers\FeedbackController::class, 'feedback');
    //     Route::admin(Controllers\MessageController::class, 'message');
    //     LaravelRoute::group(['middleware' => 'web'], function() use ($prefix) {
    //         LaravelRoute::get($prefix.'/auth/login', '\Friparia\Admin\Controllers\AuthController@login')->name('admin.login');
    //         LaravelRoute::get($prefix.'/auth/logout', '\Friparia\Admin\Controllers\AuthController@logout')->name('admin.logout');
    //         LaravelRoute::get($prefix.'/auth/forget', '\Friparia\Admin\Controllers\AuthController@forget')->name('admin.forget');
    //         LaravelRoute::post($prefix.'/auth/change-password', '\Friparia\Admin\Controllers\AuthController@changePassword')->name('admin.change');
    //         LaravelRoute::get($prefix.'/auth/captcha/{username}', '\Friparia\Admin\Controllers\AuthController@captcha')->name('admin.change');
    //         LaravelRoute::group(['middleware' => ['admin']], function () use ($prefix) {
    //             LaravelRoute::get($prefix . '/',  '\Friparia\Admin\Controllers\AdminController@index')->name('admin.index');
    //             LaravelRoute::get($prefix.'/data', '\Friparia\Admin\Controllers\DataController@index');
    //             LaravelRoute::get($prefix.'/data/export', '\Friparia\Admin\Controllers\DataController@export');
    //         });
    //     });
    // }
    //
    /**
     * @param $model
     * @param string $name
     * @param string $classname
     * @param string $prefix
     */
    public static function rest($model, $prefix = "admin", $name = "", $classname = ''){
        if($name == "") {
            $name = Str::snake(class_basename($model));
        }
        if($classname == "") {
            $classname = "\\Friparia\\RestModel\\AdminController";
        }
        $instance = new $model;
        self::get($prefix.'/'.$name.'/configuration', function() use ($instance){
            return response()->json($instance->getConfiguration());
        });
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
