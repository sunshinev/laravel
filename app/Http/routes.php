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
Route::get('welcome', function () {
    return view('welcome');
});

Route::get('home','Index\IndexController@index');
// 认证路由...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// 注册路由...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::group(['middleware'=>'auth'],function() {
    // 模板指向
    Route::get('admin', 'Admin\AdminController@index');
    Route::get('admin/article/add', 'Admin\AdminController@articleAdd');
    Route::get('admin/article/manage', 'Admin\AdminController@articleManage');
    Route::get('admin/class/manage', 'Admin\AdminController@classManage');
    // post 请求处理
    Route::post('admin/article/delete','Article\ArticleController@delete');
    Route::post('admin/article/draft','Article\ArticleController@draft');
    Route::post('admin/article/publish','Article\ArticleController@publish');


});


