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
        Route::get('notifications', 'NotificationController@index')->name('notifications.index');
        Route::get('notifications/markAsRead', 'NotificationController@readNotification')->name('notifications.read');
        Route::get('notifications/unReads', 'NotificationController@unReads')->name('notifications.unread');

    });
    Route::namespace('Expense')->prefix('expenses')->name('expenses.')->group(function () {
        Route::resource('{expense}/uploads', 'UploadAttachmentController', ['only' => ['store', 'destroy']]);
    });
    Route::namespace('Sale')->prefix('sales')->name('sales.')->group(function () {
        Route::resource('{sale}/uploads', 'MediaController', ['only' => ['store', 'destroy']]);
    });
    Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
    Route::resource('roles', 'RoleController', ['except' => ['create', 'edit']]);
    Route::resource('permissions', 'PermissionController', ['except' => ['create', 'edit']]);
    Route::resource('suppliers', 'SupplierController', ['except' => ['create', 'edit']]);
    Route::resource('makes', 'MakeController', ['except' => ['create', 'edit']]);
    Route::resource('models', 'ModelsController', ['except' => ['create', 'edit']]);
    Route::resource('customers', 'CustomerController', ['except' => ['create', 'edit']]);
    Route::resource('colors', 'ColorController', ['except' => ['create', 'edit']]);
    Route::get('products/filter', 'ProductController@findBy')->name('products.findBy');
    Route::resource('products', 'ProductController', ['except' => ['create', 'edit']]);
    Route::resource('sales', 'SaleController', ['except' => ['create', 'edit']]);
    Route::resource('expenses', 'ExpenseController', ['except' => ['create', 'edit']]);
    Route::get('reports', 'ReportController@groupByMake')->name('reports.group-by-make');
    Route::resource('loans', 'LoanController', ['except' => ['create', 'edit']]);
    Route::namespace('Payroll')->prefix('payrolls')->name('payrolls.')->group(function () {
        Route::resource('histories', 'HistoryController', ['only' => ['index']]);
    });
    Route::resource('payrolls', 'PayrollController', ['except' => ['create', 'edit']]);
    Route::get('revenues/product-by-supplier', 'RevenueController@productBySupplier')->name('revenues.productBySupplier');
    Route::resource('revenues', 'RevenueController', ['only' => ['index']]);
});
