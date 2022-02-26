<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('user', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('pr', PurchaseRequestController::class);
    Route::resource('purchase-order', PurchaseOrderController::class);
    Route::resource('remarks', RemarksController::class);
    Route::get('product', 'PurchaseRequestController@getProduct');
    Route::get('product_price', 'PurchaseRequestController@getProductUnitPrice');
    Route::post('write_access', 'UserController@writeAccess')->name('write_access');
});
