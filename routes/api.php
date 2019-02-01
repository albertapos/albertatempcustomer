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
/*
Route::group(['prefix' => 'admin','namespace' => 'Admin','middleware' => ['auth:api','role:admin','StoreDatabaseSelection']],function(){

	Route::get('/', 'DashboardController@index');
	Route::resource('/vendors', 'StoreController');
	Route::resource('/users', 'UserController');
	Route::resource('/products', 'ProductController');
	Route::resource('/reports','ReportController');
	
});
/*
Route::group(['prefix' => 'vendor','namespace' => 'Vendor','middleware' => ['auth:api','role:vendor|admin','StoreDatabaseSelection']],function(){

	 Route::get('/', 'DashboardController@index');
	 Route::resource('/myProfile', 'ProfileController');
	 Route::resource('/products', 'ProductController');
	 Route::resource('/stores', 'StoreController');

});

Route::group(['prefix' => 'sales','namespace' => 'Sales','middleware' => ['auth:api','role:vendor|sales']], function () {
	 Route::get('/', 'DashboardController@index');
	 Route::resource('vendors', 'StoreController');
	 Route::resource('/users', 'UserController');
});


*/

