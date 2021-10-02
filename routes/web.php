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

use Twilio\Rest\Client;
//use DB;

Route::get('/send/sms', function () {
    

    // Find your Account Sid and Auth Token at twilio.com/console
    $sid    = "ACa8c87fca37c40449e379abc33d76038a";
    $token  = "d91e0aff9e96bb3b11620bca51b06562";
    $twilio = new Client($sid, $token);
    
    $message = $twilio->messages
                      ->create("+918921007852", // to
                               array(
                                   "body" => "This is the ship that made the Kessel Run in fourteen parsecs?",
                                   "from" => "+15124886048"
                               )
                      );
    
    print($message->sid);
    
    
    
    
    
    return 'welcome';
});

//Route::get('/getBySKU','PromotionController@getBySKU');
Route::get('/kill/mysql/processes', function(){
    
    $result = DB::select("SHOW FULL PROCESSLIST");
        
    foreach($result as $k => $v){
        
        if($v->Time > 200){
            
            $sql="KILL ".$v->Id;
            
            DB::connection('mysql')->select($sql);
            
            // DB::select($sql);
            echo "Killed Process ID: ".$v->Id.PHP_EOL;
        }
    }
        
    return "Killed all the above process";
});


Route::get('/test','Admin\TestController@test');

Route::get('/download', 'Admin\ProductController@getDownload');

//================= CRON JOB ===========================================
Route::get('/track/newskus', 'Admin\ProductController@track_new_skus');
Route::get('/inventory/snapshot', 'Admin\NPLController@snapshot_mst_item');
Route::get('/endofday/index', 'Admin\EndofdayController@index');

Route::get('/buydown/updateStatus', 'Admin\BuydownController@updateStatus');

Route::post('/api/convertsale/{sid}', 'StoreController@convert_sale_to_promotion');


Route::get('/automate_scan_data', 'Admin\FtpController@automate_scan_data');
Route::get('/drizzly/cronjob', 'Admin\PLCBController@drizzly_cron_job');

Route::get('/inventory_snapshot', 'Admin\InventorySnapshotController@index');




Route::post('/timeclock/attendance', 'Admin\TimeclockController@timeclock_action');
Route::get('/timeclockusers/getusers', 'Admin\TimeclockController@timeclock_getusers');
Route::post('/timeclock/gettimedetails/{user_id}', 'Admin\TimeclockController@get_time_details');
Route::post('/timeclock/report', 'Admin\TimeclockController@get_report_by_respected_user');
Route::post('/timeclock/allreports', 'Admin\TimeclockController@get_report_by_user');
Route::post('/timeclock/addschedule', 'Admin\TimeclockController@timeclock_add_new_schedule');
Route::post('/timeclock/getschedule', 'Admin\TimeclockController@timeclock_get_schedule');
Route::post('/timeclock/salebyamountrange', 'Admin\TimeclockController@get_report_by_seles_amountrange');



Route::get('/api/current25transactions/{store_id}', 'Admin\StoreController@get_current_25_transactions');
Route::get('/api/get_last_7days_transactions/{store_id}', 'Admin\StoreController@get_last_7days_transactions');
Route::get('/api/get_last_4weeks_transactions/{store_id}', 'Admin\StoreController@get_last_4weeks_transactions');
Route::get('/api/get_last_12months_transactions/{store_id}', 'Admin\StoreController@get_last_12months_transactions');

Route::post('/api/storeprocedure', 'Admin\StoreController@add_store_procedure');

/*venkat:  Thsi is the route for revicing order api  */
Route::get('/api/get_reciving_order', 'Admin\StoreController@get_reciving_order');


Route::get('/api/current25transactionsbydate', 'Admin\StoreController@get_report_by_seles_date');


Route::get('/api/notifications/{store_id}', 'Admin\StoreController@notifications');
//Transferred on Mar 26, 2020 on Manish's request
Route::get('/api/notifications_new/{store_id}', 'Admin\StoreController@notifications_new');

Route::post('/api/getbatches', 'Admin\StoreController@get_batches');
Route::get('/api/getbatchdetail', 'Admin\StoreController@get_batch_detail');
Route::get('/api/geteoddetail', 'Admin\StoreController@get_eod_detail');


Route::post('/api/uploadimage', 'Admin\UploadController@fileUpload');
Route::post('/api/getimage', 'Admin\UploadController@getImage');

Route::get('/api/base64image', 'Admin\UploadController@getImagePreview');

Route::post('/api/uploadbase64image', 'Admin\UploadController@uploadbase64image');



Route::get('/api/convertupca2upce', 'Admin\ProductController@convert_upca_2_upce');
Route::get('/api/convertupce2upca', 'Admin\ProductController@convert_upce_2_upca');


Route::post('/eod', 'Admin\ProductController@end_of_day');

Route::get('/', 'DashboardController@index');
//Route::get('/products/image/{id}', 'Admin\ProductController@getImage');
Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/authenticate', 'AuthenticateController@authenticate');
Route::post('/login', 'Auth\LoginController@postLogin');
Route::get('auth/logout', 'Auth\LoginController@logout');
Route::get('/logout', 'Auth\LoginController@logout');
Route::post('/logout', 'Auth\LoginController@logout');
Route::post('/authenticate_new', 'AuthenticateController@authenticate_new');
Route::post('/authenticate_new_data', 'AuthenticateController@authenticate_new_data');

/*Route::get('api/department/list/{sid}', 'Admin\ProductController@get_department_list');
Route::get('api/category/list/{sid}', 'Admin\ProductController@get_category_list');
Route::get('api/vendor/list/{sid}', 'Admin\ProductController@get_vendor_list');*/

Route::post('api/admin/insertmobile', 'Admin\CustmobController@temporary_insert_mobile');
Route::post('api/admin/getmobile', 'Admin\CustmobController@get_mobile');
Route::post('api/admin/insertcustomer', 'Admin\CustmobController@insert_mobile_customer');

// Route::get('/category/list/{sid}/{department_code}', 'Admin\ProductController@get_category_list');



Route::get('api/password/{password}', 'Admin\ProductController@make_password');



// Route::get('/getItemBySKU', 'Admin\ProductController@get_item_by_sku');
    // Route::post('/insert/item/customer', 'Admin\ProductController@insert_item_customer');


Route::group(['middleware' => ['StoreDatabaseSelection']],function(){

   Route::get('/webProducts', 'StoreController@getUidStore');
  // Route::get('/webProductsDetail', 'StoreController@getProductDetail');

});



// Route::post('/newskulistsearch', 'Admin\NPLController@new_sku_list_search');

Route::get('/paginated', 'Admin\NPLController@paginated_result');


Route::group(['prefix' => 'admin','namespace' => 'Admin','middleware' => ['auth','role:admin|vendor|storemanager|SuperAdmin|StoreAdmin','StoreDatabaseSelection']],function(){
    
    Route::group(['prefix' => 'npl'],function(){
        
        Route::resource('/departments', 'DepartmentController');
        Route::resource('/categories', 'CategoryController');
        Route::resource('/subcategories', 'SubcategoryController');
        Route::resource('/manufacturers', 'ManufacturerController');
        Route::resource('/units', 'UnitController');
        Route::resource('/sizes', 'SizeController');
        Route::get('/transfer','NPLController@data_transfer');
        
        Route::post('/get_items_from_departments', 'NPLController@get_department_items');
        Route::post('/get_department_categories', 'NPLController@get_department_categories');
        
        Route::post('/get_category_items', 'NPLController@get_category_items');
        Route::post('/get_category_sub_categories', 'NPLController@get_category_sub_categories');
        
        Route::post('/transfer','NPLController@data_transfer_to_store');

    });
    
    //-----------------------NPL list-------------------------------
    Route::get('/npl-list', 'NPLController@index');
    Route::get('/npl-list-insert', 'NPLController@create');
    Route::post('/npl-list-store', 'NPLController@store');
    Route::get('/npl-list-edit/{id}', 'NPLController@edit');
    Route::post('/npl-list-update/{id}', 'NPLController@update');
    Route::post('/npl-list-delete/{id}', 'NPLController@delete');
    Route::post('/delete/multiple/nplitems', 'NPLController@delete_multiple_nplitems');
    Route::get('/npl-items', 'NPLController@getNplItems');
    Route::get('/new-sku-to-npl', 'NPLController@newSkuToNpl');
    Route::post('/npl-list/search', 'NPLController@search');
    
     
    
    Route::get('/npl-list-editmulti', 'MultieditController@index');
    Route::post('/npl_list_edit_multi_items', 'MultieditController@edit_items_multiple');
    Route::post('/npl-list-update_multi_items', 'MultieditController@multi_update');
    Route::post('/npl-list_multi/search', 'MultieditController@search');
    Route::post('/npl_cat', 'MultieditController@category');
    Route::post('/npl_sub', 'MultieditController@subcategory');
    
    Route::post('/departments/search', 'DepartmentController@search');
    Route::post('/categories/search', 'CategoryController@search');
    Route::post('/subcategories/search', 'SubcategoryController@search');
    Route::post('/manufacturers/search', 'ManufacturerController@search');
    Route::post('/units/search', 'UnitController@search');
    Route::post('/sizes/search', 'SizeController@search');
    
    Route::post('/npl/uploadcsv', 'NPLController@upload_csv');
    
    // //-----------------------News Update---------------------
    // Route::get('/newsupdate', 'NewsUpdateController@index');
    
    
    //-----------------------NEW SKUs-------------------------------
    Route::get('/newskus', 'NPLController@new_skus_list');
    Route::post('/newskulistsearch', 'NPLController@new_sku_list_search');
    Route::get('/edit/newskulist/{barcode}', 'NPLController@edit_newly_added_item');
    Route::post('/sendtonpl', 'NPLController@send_to_npl');
    
    
    https://devportal.albertapayments.com/admin/edit/newskulist/7766

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
	Route::post('/systemOption/{id}/edit','SystemOptionController@postEdit');


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
	Route::resource('/systemOption', 'SystemOptionController');
	//Route::resource('/reports','ReportController');
	Route::get('/store-list', 'StoreController@getStoreList');
	
});

   //-----------------------News Update---------------------
    Route::get('/newsupdate', 'Admin\NewsUpdateController@index');
    Route::get('/newsupdatecreate', 'Admin\NewsUpdateController@create');
    Route::post('/newsupdateadd', 'Admin\NewsUpdateController@newsupdateadd');
    Route::get('/newsupdateedit/{id}/edit', 'Admin\NewsUpdateController@edit');
    Route::put('/newsupdateupdate', 'Admin\NewsUpdateController@update');
    Route::get('/newsdestroy/{id}', 'Admin\NewsUpdateController@destroy');
    Route::get('/newsupdateview/{id}', 'Admin\NewsUpdateController@newsupdateview');
    
    
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

Route::post('/api/register', 'Admin\CustomerController@register');

Route::get('/api/notoken/getLast20Transaction','Admin\ReportController@notoken_getLast20Transaction');


//Route::group(['prefix' => 'api','middleware' => ['jwt-auth', 'jwt.refresh']],function(){
    Route::group(['prefix' => 'api','middleware' => ['jwt-auth']],function(){
    


	Route::get('/me','AuthenticateController@getUserByToken');
	Route::get('/me_new_date','AuthenticateController@getUserByToken_new_date');
	
	Route::get('/storedetails/{sid}', 'AuthenticateController@getStoreDetail');
	
	Route::get('/storedetails_new/{sid}', 'AuthenticateController@getStoreDetail_new');
	Route::get('/storedetailsbydate', 'AuthenticateController@getStoreDetailBydate');
});
Route::group(['prefix' => 'api/admin','namespace' => 'Admin','middleware' => ['jwt-auth']],function(){

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
	//Transferred on Mar 26, 2020 on Manish's request
	Route::post('/updatePriceBySKU_new','ProductController@updatePriceBySKU_new');
	//end
	
	Route::get('/zreport','ProductController@Zreport');
	Route::get('/end_of_report','ProductController@end_of_report');
	Route::get('/subcategorysid','ProductController@get_subcategory_sid');
	Route::post('/updateQuantityBySKU','ProductController@updateQuantityBySKU');
	
	Route::get('/checkPriceBySKU_new','ProductController@check_price_by_sku_new');
// 	Route::get('/getBySKU','PromotionController@getBySKU');
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
// 	Route::get('/get25','ReportController@getLast25bydateTransaction');
	

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
    Route::get('/getItemBySKU_new', 'ProductController@get_item_by_sku_new');
    
    
    
    Route::post('/insert/item/fromnpl', 'ProductController@insert_item_from_npl');
    
    Route::get('/department/list/{sid}', 'ProductController@get_department_list');
    Route::get('/category/list/{sid}/{department_code}', 'ProductController@get_category_list'); 
    Route::get('/subcategory/list/{sid}/{category_id}', 'ProductController@get_subcategory_list');    
    Route::get('/vendor/list/{sid}', 'ProductController@get_vendor_list');
    Route::get('/ageverification/list/{sid}', 'ProductController@get_age_verification_list');
    
    // Route::post('/insertmobile', 'CustmobController@insert');
    
    //------------------------Receiving Module Api------------------

    Route::get('/get_receiving_order/{store_id}', 'ReceivingOrderController@get_receiving_order');
	Route::get('/get_vendor_list', 'ReceivingOrderController@get_vendor_list');
	Route::get('/get_new_vendor_list', 'ReceivingOrderController@get_new_vendor_list');
	Route::post('/insert_ro_details', 'ReceivingOrderController@insert_ro_details'); 
	Route::get('/get_item_with_vendoritemcode', 'ReceivingOrderController@get_item_with_vendoritemcode');
	Route::get('/get_item_with_name', 'ReceivingOrderController@get_item_with_name');
	Route::get('/new_get_item_with_name', 'ReceivingOrderController@new_get_item_with_name');
	Route::get('/get_itemdetails_with_barcode', 'ReceivingOrderController@get_itemdetails_with_barcode');
	Route::post('/insert_ro_items', 'ReceivingOrderController@insert_ro_items');
	Route::get('/get_order_items', 'ReceivingOrderController@get_order_items');
	Route::post('/edit_multiple_ro_items_save', 'ReceivingOrderController@edit_multiple_ro_items_save');
	Route::post('/edit_multiple_ro_items_finalize', 'ReceivingOrderController@edit_multiple_ro_items_finalize');
	Route::post('/save_receive_ro_items', 'ReceivingOrderController@save_receive_ro_items');
	
	Route::get('/get_other_costs', 'ReceivingOrderController@get_other_costs');
    Route::post('/add_other_costs', 'ReceivingOrderController@add_other_costs');

	Route::post('/post_receiving_order', 'ReceivingOrderController@post_receiving_order');
	
	
	
	//print api hanamant
	Route::post('/addbarcode', 'PrintController@insert_barcode');
	Route::post('/deletebarcode', 'PrintController@delete_barcode');
	Route::get('/openstatus', 'PrintController@openstatus');
	Route::post('/closestatus', 'PrintController@closestatus');
	Route::post('/printstatus', 'PrintController@printstatus');
	
	Route::post('/taxinfo', 'PrintController@taxinfo');
	Route::post('/taxinfo', 'PrintController@add_store_procedure');
	Route::get('/z_report', 'PrintController@zreport');
	Route::get('/zreport_detail', 'PrintController@zreport_detail');
	
	

	
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
/*Route::get('/plcb-insert-end','ManualController@index');
Route::get('/plcb-swap','ManualController@swapdata');
Route::get('/plcb-item-detail-insert','ManualController@insertplcbdetail');*/

Route::get('/laravel-db','StoreController@getLaravelDb');
Route::get('/simple-db','StoreController@getSimpleDb');

Route::get('/plcb_update', 'Admin\PLCBController@plcb_update');
Route::get('/plcb_insert', 'Admin\PLCBController@insert_plcb_data');
// Route::get('/plcb_insert_item', 'Admin\PLCBController@insert_plcb_item');
// Route::get('/plcb_insert_item_detail', 'Admin\PLCBController@insert_plcb_item_detail');
Route::get('/plcb_insert_items', 'Admin\PLCBController@insert_plcb_items');


//testing purpose only
// Route::post('/api/edit_multiple_ro_items', 'Admin\ReceivingOrderController@edit_multiple_ro_items');
// Route::post('/api/save_receive_ro_items', 'Admin\Testapi@save_receive_ro_items');
// Route::get('/api/admin/get_other_costs', 'Admin\ReceivingOrderController@get_other_costs');
// Route::post('/api/admin/add_other_costs', 'Admin\ReceivingOrderController@add_other_costs');

Route::group(['prefix' => 'api/admin','namespace' => 'Admin',],function(){
Route::get('/posopenstatus', 'PrintController@openstatus');
Route::get('/new_get_item_with_pi', 'Physical_InventoryController@new_get_item_with_name');
Route::get('/get_sku', 'Physical_InventoryController@getBySKU');
Route::get('/get_sku_user', 'Physical_InventoryController@getBySKUUser');
Route::post('/insert_sku_next', 'Physical_InventoryController@Inserting_SKU_next');
Route::post('/sku_finish', 'Physical_InventoryController@SKU_finish'); 
Route::get('/after_sku_finish', 'Physical_InventoryController@after_sku_finish');
Route::get('/exportuser', 'Physical_InventoryController@exporting_users');
Route::get('/physicalinventorysku', 'Physical_InventoryController@getBySKU');
Route::get('/getByPermission', 'UserPermissionController@getByPermission');
Route::get('/getAllPromotionType', 'PromotionController@get_all_promotion_type');
Route::get('/getAllPromotion', 'PromotionController@get_all_promotion');
Route::post('/addPromotion', 'PromotionController@add_promotion');
Route::post('/editPromotion', 'PromotionController@edit_promotion'); 
Route::get('/editPromotionView', 'PromotionController@edit_promotion_view'); 
Route::get('/addPromotionItems', 'PromotionController@add_promotion_items');
Route::get('/showPromotionItems', 'PromotionController@show_promotion_items');
Route::post('/removePromotionItems', 'PromotionController@remove_promotion_items');
Route::get('/get_by_main_menu_permission', 'UserPermissionController@getByPermission');
// Route::get('/get_by_sub_menu_permission', 'UserPermissionController@getByAllPermission');
Route::get('/get_by_main_nav_menu_permission', 'UserPermissionController@getByNavPermission');
Route::get('/get_by_sub_menu_permission', 'UserPermissionController@getByAllPermission');

Route::get('/unit/list/{sid}', 'ProductController@get_unit_list');
Route::get('/manufacture/list/{sid}', 'ProductController@get_manufacture_list');
Route::get('/size/list/{sid}', 'ProductController@get_size_list');


});

