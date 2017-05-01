<?php
Route::post('/admin/auth/signout', '\Friparia\Admin\Controllers\AuthController@signout')->name('admin.signout');

Route::post('/admin/auth/signin', '\Friparia\Admin\Controllers\AuthController@signin')->name('admin.signin');

//testing
Friparia\RestModel\Route::rest(Friparia\Admin\Models\User::class, "api");

