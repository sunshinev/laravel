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

Route::get('/','Index\IndexController@index')->middleware(['navi']);
Route::get('/article/{article_id}','Index\IndexController@article')->middleware(['navi']);
// 认证路由...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// 注册路由...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::group(['middleware'=>'auth'],function() {

    // 文章管理 begin
    // 模板指向
    Route::get('admin', 'Admin\AdminController@index');
    Route::get('admin/article/add', 'Admin\AdminController@articleAdd');
    Route::get('admin/article/manage', 'Admin\AdminController@articleManage');

    Route::post('admin/article/delete','Admin\ArticleController@delete');
    Route::post('admin/article/draft','Admin\ArticleController@draft');
    Route::post('admin/article/publish','Admin\ArticleController@publish');
    Route::post('admin/category/getNextLayerNodesByAjax','Admin\CategoryController@getNextLayerNodesByAjax');

    Route::get('admin/article/edit/{article_id}','Admin\AdminController@articleEdit');
    // 文章管理 end

    // 分类管理 begin
    Route::get('admin/category/manage','Admin\AdminController@categoryManage');
    Route::get('admin/category/manage/{child_id}_{pid}','Admin\AdminController@categoryManageWithParams');

    Route::post('admin/category/add','Admin\CategoryController@insertNode');
    Route::post('admin/category/edit','Admin\CategoryController@updateNode');
    Route::post('admin/category/remove','Admin\CategoryController@removeNode');
    // 分类管理 end

});


