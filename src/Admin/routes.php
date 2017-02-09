<?php
Route::group(['middleware' => [\Tymon\JWTAuth\Middleware\GetUserFromToken::class]], function () {
    Route::get('/admin/menu', function(){
        return response()->json(config('menu'));
    });
});
Route::post('/admin/auth/signin', '\Friparia\Admin\Controllers\AuthController@signin')->name('admin.signin');
Route::get('/admin/', function(){
    return view('admin::index');
});
