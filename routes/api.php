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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Admin')->group(function () {
    Route::resource('categories', 'CategoryController', ['except' => ['create', 'edit']]);
    Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
    Route::resource('roles', 'RoleController', ['only' => ['index']]);
    Route::resource('suppliers', 'SupplierController', ['except' => ['create', 'edit']]);
    Route::resource('makes', 'MakeController', ['except' => ['create', 'edit']]);
    Route::resource('models', 'ModelsController', ['except' => ['create', 'edit']]);
    Route::resource('customers', 'CustomerController', ['except' => ['create', 'edit']]);
});
