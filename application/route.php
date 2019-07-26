<?php
use think\Route;
//路由文件
//Banner
Route::get('api/:version/banner/:id','api/:version.Banner/getBanner');

//Item
Route::get('api/:version/theme','api/:version.Theme/getSimpleList');

// itemList 专题内页列表
Route::get('api/:version/theme/:id','api/:version.Theme/getComplexOne');

Route::group('api/:version/product',function (){
    Route::get('/recent','api/:version.Product/getRecent');//Home-Product
    Route::get('/by_category','api/:version.Product/getAllInCategory');// Category_Product
    Route::get('/:id','api/:version.Product/getOne',[],['id'=>'\d+']);//Category_detail
});

//Category
Route::get('api/:version/category/all','api/:version.Category/getAllCategories');

//Token
Route::post('api/:version/token/user', 'api/:version.Token/getToken');
//Token
Route::post('api/:version/token/verify', 'api/:version.Token/verifyToken');

//Address
Route::post('api/:version/address','api/:version.Address/createOrUpdateAddress');
Route::get('api/:version/address','api/:version.Address/getUserAddress');

//Order

Route::post('api/:version/order','api/:version.Order/placeOrder');

Route::get('api/:version/order/by_user','api/:version.Order/getSummaryByOrder');

Route::get('api/:version/order/:id','api/:version.Order/getDetail',[],['id'=>'\d+']);


//Pay
Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');
Route::post('api/:version/pay/notify', 'api/:version.Pay/receiveNotify');
Route::post('api/:version/pay/re_notify', 'api/:version.Pay/redirectNotify');











