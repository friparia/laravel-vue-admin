<?php
Route::get('/admin/', function(){
    return view('admin::index');
});
Route::get('/admin/menu', function(){
    return response()->json(config('menu'));
});
Route::post('/admin/auth/signin', '\Friparia\Admin\Controllers\AuthController@signin')->name('admin.signin');
