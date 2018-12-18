<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Admin')->group(function () {
    Route::get('user', 'User\AuthController@show')->name('auth.user');
    Route::resource('categories', 'CategoryController', ['except' => ['create', 'edit']]);
    Route::namespace('User')->prefix('users')->name('users.')->group(function () {
        Route::post('{user}/upload-avatar', 'UploadAvatarController@upload')->name('upload-avatar');
    });
    Route::namespace('Product')->prefix('products')->name('products.')->group(function () {
        Route::delete('{product}/{colorId}', 'ColorController@destroyColor')->name('destroy.color');
    });
    Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
    Route::resource('roles', 'RoleController', ['only' => ['index']]);
    Route::resource('suppliers', 'SupplierController', ['except' => ['create', 'edit']]);
    Route::resource('makes', 'MakeController', ['except' => ['create', 'edit']]);
    Route::resource('models', 'ModelsController', ['except' => ['create', 'edit']]);
    Route::resource('customers', 'CustomerController', ['except' => ['create', 'edit']]);
    Route::resource('colors', 'ColorController', ['except' => ['create', 'edit']]);
    Route::resource('products', 'ProductController', ['except' => ['create', 'edit']]);
});
