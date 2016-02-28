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

/**
 * 接口---请求
 */
Route::any('service/validate_code/create', 'Service\ValidateController@create');//生成请求验证码图片
Route::any('service/validate_phone/send', 'Service\ValidateController@sendSMS');//请求发送短信验证
Route::any('service/validate_email', 'Service\ValidateController@validateEmail');//验证邮箱请求
Route::post('service/register', 'Service\MemberController@register');//注册请求

