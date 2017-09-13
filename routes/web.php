<?php

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
//打开首页、帮助页、关于页
Route::get('/','StaticPagesController@home')->name('home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');
//用户注册
Route::get('signup','UsersController@create')->name('signup');
/*这一段代码与下面的一句代码功能相同
Route::get('/users', 'UsersController@index')->name('users.index');
Route::get('/users/{user}', 'UsersController@show')->name('users.show');
Route::get('/users/create', 'UsersController@create')->name('users.create');
Route::post('/users', 'UsersController@store')->name('users.store');
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');
*/
Route::resource('users','UsersController');
//打开登陆页面，登陆，登出
Route::get('login','SessionController@create')->name('login');
Route::post('login','SessionController@store')->name('login');
Route::delete('logout','SessionController@destroy')->name('logout');
//点击链接确认激活账户
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');
//微博的发布和删除
Route::resource('statuses','StatusesController',['only'=>['store', 'destroy']]);
//获取我关注的人
Route::get('/users/{user}/followings', 'UsersController@followings')->name('users.followings');
//获取我的粉丝
Route::get('/users/{user}/followers', 'UsersController@followers')->name('users.followers');
//关注用户
Route::post('/users/followers/{user}', 'FollowerController@store')->name('followers.store');
//取消关注用户
Route::delete('/users/followers/{user}', 'FollowerController@destroy')->name('followers.destroy');
