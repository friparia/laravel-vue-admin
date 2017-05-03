<?php
Route::group(['middleware' => 'web'], function(){
    Route::get('/admin/auth/signin', function(){
        return view('admin::signin');
    });
    Route::post('/admin/auth/signin', '\Friparia\Admin\Controllers\AuthController@signin')->name('admin.signin');
    Route::group(['middleware' => 'auth'], function(){
        Friparia\RestModel\Route::admin(Friparia\Admin\Models\User::class);
        Route::post('/admin/auth/signout', '\Friparia\Admin\Controllers\AuthController@signout')->name('admin.signout');
    });
});
