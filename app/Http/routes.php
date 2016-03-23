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

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('/', function(){
    return view('login');
});

/**
 * view---视图请求
 */
Route::get('/login', 'View\MemberController@toLogin');
Route::get('/register', 'View\MemberController@toRegister');

Route::get('/category', 'View\BookController@toCategory');
Route::get('/category/products/{category_id}', 'View\BookController@productByCategoryId');
Route::get('/product/{product_id}', 'View\BookController@toPdtContent');


Route::group(['middleware' => 'check.login'], function(){
    Route::get('/cart', 'View\CartController@toCart');//到达购物车界面
    Route::match(['get', 'post'], '/order_commit', 'View\OrderController@toOrderCommit');//到达订单生成界面
});

/**
 * 接口---请求
 */

Route::group(['prefix' => 'service'], function(){
    Route::get('validate_code/create', 'Service\ValidateController@create');//生成请求验证码图片
    Route::post('validate_phone/send', 'Service\ValidateController@sendSMS');//请求发送短信验证
    Route::get('validate_email', 'Service\ValidateController@validateEmail');//验证邮箱请求
    Route::post('register', 'Service\MemberController@register');//注册请求
    Route::post('login', 'Service\MemberController@login');//登录
    Route::get('category/parent_id/{parent_id}','Service\BookController@getCategoryByParentId');
    Route::get('cart/add/{product_id}','Service\CartController@addCart');
    Route::get('cart/delete', 'Service\CartController@removeCart');//重购物车中删除
});


//到达订单列表---就需要强制用户登录
//Route::get('/order_list', 'View\OrderController@toOrderList')->middleware(['check.login']);

//Route::any('sendMes', 'Service\ValidateController@sendSMS');//请求发送短信验--测试

