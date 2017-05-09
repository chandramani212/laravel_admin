<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function () {
    return view('home');
})->middleware('auth');


Route::controller('customer/general','CustomerGeneralController');

Route::resource('customer', 'CustomerController');

Route::controller('customerHistory/general','CustomerHistoryGeneralController');

Route::resource('customerHistory', 'CustomerHistoryController');

Route::controller('customerPrice/general','CustomerPriceGeneralController');

Route::resource('customerPrice', 'CustomerPriceController');

Route::controller('paymentReceipt/general','PaymentReceiptGeneralController');

Route::resource('paymentReceipt', 'PaymentReceiptController');



Route::controller('customPrice/general','CustomPriceGeneralController');

Route::resource('customPrice', 'CustomPriceController');
Route::resource('customPriceList', 'CustomPriceListController');


Route::controller('order/general','OrderGeneralController',['getExcel' => 'OrderGeneralExcel' ]);

Route::resource('order', 'OrderController');

Route::controller('orderHistory/general','OrderHistoryGeneralController');

Route::resource('orderHistory', 'OrderHistoryController');

Route::controller('invoice/general','InvoiceGeneralController');

Route::resource('invoice', 'InvoiceController');

Route::controller('product/general','ProductGeneralController');

Route::controller('attribute/general','AttributeGeneralController');

Route::controller('stock/general','StockGeneralController');

Route::resource('stock', 'StockController');

Route::controller('state/general','StateGeneralController');

Route::resource('state', 'StateController');

Route::controller('city/general','CityGeneralController');

Route::resource('city', 'CityController');

Route::controller('locality/general','LocalityGeneralController');

Route::resource('locality', 'LocalityController');

Route::controller('export','ExportController',['getStocksummary' => 'StockSummaryIndex','getOrderscustomer' => 'OrderCustomerIndex','getOrdercustomerlocality'=>'getOrdercustomerlocality' , 'getCommonexport' => 'CommonExportIndex' ,'getCustomercomment' => 'CustomerCommentIndex',
	'getOrderreceipt' => 'OrderReceiptSummaryIndex' ]);

Route::resource('tookan', 'Api\Tookan\TookanController');
// vijay sir controllers

Route::auth();

Route::get('/home', 'HomeController@index')->name('backhome');

//Route::post('backhome','HomeController@index');

Route::resource('product','ProductController');

Route::post('/allproduct','gerneralController@allProduct');
Route::controller('productattributeprice/general','ProductAttributePriceGeneralController');
Route::get('/attrpricehistory/{attributeId}','gerneralController@attributePriceHistory')->name('ProductAttributePriceHistory');

Route::resource('procurement','procurementController');


Route::post('/procurementDetails','gerneralController@procurement_details');

/*added by vijay for update restourent zone*/
Route::POST('/zoneupdate','gerneralController@zoneupdate');



Route::get('/roles', [
        'uses' => 'userroleController@index', 
        'as' => 'role'
    ]);


Route::get('/createroles',[
	'uses'=>'userroleController@create_role',
	'as'=>'createroles'
	]);


Route::get('/setpermision',[
	'uses'=>'userroleController@userpermision',
	'as'=>'setpermision'
	]);

Route::get('/permission',[
		'uses' => 'userroleController@user_permission', 
        'as' => 'permission'
	]);





Route::post('/create_permission','userroleController@create_permission');

Route::post('/save_roles','userroleController@save_roles');

Route::post('/set_userpermission','userroleController@set_userpermission');


// /*
// *  applying authd meddel ware on all controller
// */


// Route::group(['prefix' => 'customer', 'middleware' => ['role:admin|woner']], function() {
// //    Route::get('/', 'AdminController@welcome');
//  //   Route::resource('customer', 'CustomerController',['middleware' => ['permission:manage-customer'], 'uses' => 'CustomerController']);
//     //Route::get('/manage', ['middleware' => ['permission:manage-customer'], 'uses' => 'AdminController@manageAdmins']);
// });



// Route::group(['middleware' => ['role:agnet']], function()
// {
//   //echo "WE are at here in middleware"; exit;
//    Route::resource('customer', 'CustomerController',['middleware' => ['permission:all Operation']]);
// });


// added by vijay 

Route::get('/exportprocurement','ExportProcurement@index')->name('exportprocurement');

Route::post('/export_procurement','ExportProcurement@export_procurement');


Route::get('/category','categoryController@index');
/*Route::get('/addcategory','categoryController@create');
routes::POST('/store','categoryController@store');*/

Route::resource('category','categoryController');
Route::post('/categorylist','gerneralController@categorylist');


/* added by vijay for export customer/merchant basic info as per datewise order place */
Route::get('/exportcustomer','customExportController@export_customer');

//added by vijay for percurment purpose
Route::controller('procurementgeneral','procurementgeneralController');


//added by vijay for zone perpose

Route::resource('zone', 'zoneController');
    