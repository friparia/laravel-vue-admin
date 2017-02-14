<?php
Route::group(['middleware' => [\Tymon\JWTAuth\Middleware\GetUserFromToken::class]], function () {
    Route::get('/admin/menu', function(){
        return response()->json(config('menu'));
    });
});

Route::post('/admin/auth/signin', '\Friparia\Admin\Controllers\AuthController@signin')->name('admin.signin');
Friparia\RestModel\Route::rest(Friparia\Admin\Models\User::class, "api");

Route::get('/admin/{vue_capture?}', function(){
    return view('admin::index');
});
