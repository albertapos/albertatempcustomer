<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'DashboardController@index');
//Route::get('/products/image/{id}', 'Admin\ProductController@getImage');
Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/authenticate', 'AuthenticateController@authenticate');
Route::post('/login', 'Auth\LoginController@postLogin');
Route::get('auth/logout', 'Auth\LoginController@logout');
Route::get('/logout', 'Auth\LoginController@logout');
Route::post('/logout', 'Auth\LoginController@logout');


// Route::get('/getItemBySKU', 'Admin\ProductController@get_item_by_sku');
    // Route::post('/insert/item/customer', 'Admin\ProductController@insert_item_customer');

Route::post('api/admin/insertmobile', 'Admin\CustmobController@temporary_insert_mobile');
Route::post('api/admin/getmobile', 'Admin\CustmobController@get_mobile');
Route::post('api/admin/insertcustomer', 'Admin\CustmobController@insert_mobile_customer');


Route::group(['middleware' => ['StoreDatabaseSelection']],function(){

   Route::get('/webProducts', 'StoreController@getUidStore');
  // Route::get('/webProductsDetail', 'StoreController@getProductDetail');

});


Route::get('/search', 'Admin\NPLController@search');


Route::group(['prefix' => 'admin','namespace' => 'Admin','middleware' => ['auth','role:admin|vendor|storemanager','StoreDatabaseSelection']],function(){
    
    //-----------------------NPL list-------------------------------
    Route::get('/npl-list', 'NPLController@index');
    Route::get('/npl-list-insert', 'NPLController@create');
    Route::post('/npl-list-store', 'NPLController@store');
    Route::get('/npl-list-edit/{id}', 'NPLController@edit');
    Route::post('/npl-list-update/{id}', 'NPLController@update');
    Route::post('/npl-list-delete/{id}', 'NPLController@delete');
    Route::post('/delete/multiple/nplitems', 'NPLController@delete_multiple_nplitems');
    Route::get('/npl-items', 'NPLController@getNplItems');
    
    Route::post('/npl/uploadcsv', 'NPLController@upload_csv');

	Route::get('/', 'DashboardController@index');
	Route::get('/changeStore/{id}','StoreController@changeStore');

	//Route::get('/', 'HeaderController@index');

// ------------------------- Report -------------------------------------------
	Route::get('/last20transaction','ReportController@getLast20Transaction');
	//Route::get('/xSales','ReportController@getXSales');
	//Route::get('/top10SalesByQty','ReportController@getTop10SalesByQty');
	Route::get('/top10SalesByAmount','ReportController@getTop10SalesByAmount');
	Route::get('/trnSales','ReportController@getTrnSales');
	Route::get('/trnSalesDetail','ReportController@getTrnSalesDetail');
	Route::get('/trnSalesTenderDetail','ReportController@getSalesTenderDetail');
	Route::get('/itemPrice','ReportController@GetItemPrice');
	Route::post('/products/price/{id}','ProductController@editPrice');

//-----------------------------------------------------------------------------

// ------------------------ Dashboard Chart -----------------------------------
	Route::get('/dailySales','ReportController@getDailySales');
	Route::get('/7daysSales','ReportController@getSalesByDays');
	Route::get('/7daysCustomer','ReportController@getCustomerByDates');
	Route::get('/customer','ReportController@getCustomerByHours');
	Route::get('/topCategory','ReportController@getCategoryByAmount');
	Route::get('/topItem','ReportController@getTopSaleItemByDate');
	Route::get('/summary','ReportController@getSummary');
	Route::get('/charts','ReportController@getReports');
	Route::post('/charts','ReportController@postReports');

	Route::post('/users/{id}/edit','UserController@postEdit');
	Route::post('/vendors/{id}/edit','StoreController@postEdit');
	Route::post('/products/{id}/edit','ProductController@postEdit');
// 	Route::post('/systemOption/{id}/edit','SystemOptionController@postEdit');


// -------------------------------PLCB Products------------------------------
	Route::post('/plcb-products/{id}/edit', 'PLCBController@update');
	Route::resource('/plcb-products', 'PLCBController');
	Route::get('/plcb-reports', 'PLCBController@plcbReports');
	Route::get('/plcb-reports-pdf', 'PLCBController@plcbReportsPdf');
	Route::get('/plcb-reports-insert', 'PLCBController@insertData');
	Route::get('/plcb-products-list', 'PLCBController@getProductList');

// ------------------------------------------------------------------------------

// ------------------------ Databox ---------------------------------------------
	Route::get('/status','ReportController@getStatus');
//-------------------------------------------------------------------------------


//-------------------------------- View -----------------------------------------

	Route::get('/users/view/{id}','UserController@getUserView');
	Route::get('/vendors/view/{id}','StoreController@getStoreView');
	Route::get('/products/view/{id}','ProductController@getProductView');

//-------------------------------------------------------------------------------
	Route::resource('/vendors', 'StoreController');
	Route::resource('/users', 'UserController');
	Route::resource('/products', 'ProductController');
// 	Route::resource('/systemOption', 'SystemOptionController');
	//Route::resource('/reports','ReportController');
	Route::get('/store-list', 'StoreController@getStoreList');
	
});
Route::group(['prefix' => 'vendor','namespace' => 'Vendor','middleware' => ['auth','role:vendor|admin|storemanager','StoreDatabaseSelection']],function(){

	 Route::get('/', 'DashboardController@index');

	 Route::post('/myProfile/{id}/edit','ProfileController@postEdit');
	 
	 Route::resource('/myProfile', 'ProfileController');
	 //Route::resource('/products', 'ProductController');
	 Route::resource('/stores', 'StoreController');


});
Route::group(['prefix' => 'sales','namespace' => 'Sales','middleware' => ['auth','role:salesexecutive|salesadmin|salesmanager|salesagent|storemanager|kioskadmin|storeclerk|admin','StoreDatabaseSelection']], function () {
	 Route::get('/', 'DashboardController@index');
	 Route::post('/computer','StoreController@getFrom');

	 Route::post('/users/{id}/edit','UserController@postEdit');
	 Route::post('/vendors/{id}/edit','StoreController@postEdit');
	 Route::get('/vendors/{id}/users','StoreController@getUserByStore');

	//------------------------------------ View ---------------------------------------
	Route::get('/users/view/{id}','UserController@getUserView');
	Route::get('/vendors/view/{id}','StoreController@getStoreView');
	//---------------------------------------------------------------------------------

	 Route::post('/storeUsers/{id}','StoreController@postUser');

	 Route::resource('vendors', 'StoreController');
	 Route::resource('/users', 'UserController');
	 Route::resource('/agentoffice', 'AgentOfficeController');

	 Route::get('/store-list', 'StoreController@getStoreList');

});

///////////////////////////////// Token Based Authentication //////////////////////////////////////////////////////////////////////////////

Route::group(['prefix' => 'api','middleware' => ['jwt-auth']],function(){

	Route::get('/me','AuthenticateController@getUserByToken');
});
Route::group(['prefix' => 'api/admin','namespace' => 'Admin','middleware' => ['jwt-auth','role:salesexecutive|salesadmin|salesmanager|salesagent|storemanager|kioskadmin|storeclerk|admin|vendor','StoreDatabaseSelection']],function(){

	//Route::get('/', 'DashboardController@index');
	Route::resource('/vendors', 'StoreController');
	Route::post('/vendors/{id}/edit','StoreController@postEdit');


	Route::resource('/users', 'UserController');
	Route::post('/users/{id}/edit','UserController@postEdit');

	Route::resource('/products', 'ProductController');
	Route::post('/products/{id}/edit','ProductController@postEdit');


	Route::resource('/charts','ReportController');

	Route::get('/dailySummary','ReportController@getSummaryDetail');

	Route::get('/products/image/{id}', 'ProductController@getImage');
	Route::get('/categories/image/{id}', 'ProductController@getCategoryImage');

	Route::get('/checkPriceBySKU','ProductController@checkPriceBySKU');
	Route::post('/updatePriceBySKU','ProductController@updatePriceBySKU');
	// Route::get('/dailySales','ReportController@dailySalesByDate');
	Route::get('/xsales','ReportController@xSales');
	Route::get('/getLast20Transaction','ReportController@getLast20Transaction');
	Route::get('/getTop10SalesByAmount','ReportController@getTop10SalesByAmount');
	Route::get('/getTop10SalesByQty','ReportController@getTop10SalesByQty');
	Route::get('/getTransactionDetail','ReportController@getTransactionDetail');
	Route::get('/getTransaction','ReportController@getTransaction');
	Route::get('/getStoreInfo','ReportController@getStoreInfo');
	Route::get('/dashboard', 'DashboardController@getDashbord');
	Route::get('/webProductsDetail', 'ProductController@getProductDetail');
	

	//Route::get('/dailySales','ReportController@getDailySales');
	Route::get('/dailySales','ReportController@getDailySales');
	Route::get('/7daysSales','ReportController@getSalesByDays');
	Route::get('/7daysCustomer','ReportController@getCustomerByDates');
	Route::get('/customer','ReportController@getCustomerByHours');
	Route::get('/topCategory','ReportController@getCategoryByAmount');
	Route::get('/topItem','ReportController@getTopSaleItemByDate');
	Route::get('/summary','ReportController@getSummary');
	Route::get('/charts','ReportController@getReports');
	Route::post('/charts','ReportController@postReports');

	//Route::get('/charts','ReportController@getReports');
	//Route::post('/charts','ReportController@postReports');
    
    //Route::get('/getItemBySKU', 'ProductController@get_item_by_sku');
    Route::get('/getItemBySKU', 'ProductController@get_item_by_sku');
    Route::post('/insert/item/customer', 'ProductController@insert_item_customer');

	
});

Route::group(['prefix' => 'api/vendor','namespace' => 'Vendor','middleware' => ['jwt-auth','role:vendor|admin','StoreDatabaseSelection']],function(){

	 Route::get('/', 'DashboardController@index');
	 Route::resource('/myProfile', 'ProfileController');
	 Route::resource('/products', 'ProductController');
	 Route::resource('/stores', 'StoreController');

});

Route::group(['prefix' => 'api/sales','namespace' => 'Sales','middleware' => ['jwt-auth','role:vendor|salesexecutive']], function () {
	 Route::get('/', 'DashboardController@index');
	 Route::resource('vendors', 'StoreController');
	 Route::post('/vendors/{id}/edit','StoreController@postEdit');

	 Route::resource('/users', 'UserController');
	 Route::post('/users/{id}/edit','UserController@postEdit');

});

//plcb manually script
Route::get('/plcb-insert-end','ManualController@index');
Route::get('/plcb-swap','ManualController@swapdata');
Route::get('/plcb-item-detail-insert','ManualController@insertplcbdetail');

Route::get('/laravel-db','StoreController@getLaravelDb');
Route::get('/simple-db','StoreController@getSimpleDb');

