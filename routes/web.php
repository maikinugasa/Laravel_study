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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//課題30にて追記
Route::get('/', 'ItemController@index');
//商品詳細画面へ
Route::get('item/detail/{id}', 'ItemController@detail');


/*------------------------------------
	User 認証不要のページ(ホーム)
--------------------------------------*/
Route::get('/', 'ItemController@index');
/*------------------------------------
	User 認証要のページ(ログアウト)
--------------------------------------*/
Route::group(['middleware' => 'auth:user'], function() {
	Route::post('logout','Auth\LoginController@logout')->name('logout');
});
/*------------------------------------
	Admin 認証不要のページ(ログイン)
--------------------------------------*/
Route::group(['prefix' => 'admin'], function() {
	Route::get('login','Admin\Auth\LoginController@showLoginForm')->name('admin.login');
	Route::post('login','Admin\Auth\LoginController@login');
});

/*------------------------------------
	Admin 認証要のページ(管理者用ホーム・ログアウト)
--------------------------------------*/
//config/auth.phpで指定したguardsで認証されたユーザーだけにアクセス許可
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
	Route::post('logout','Admin\Auth\LoginController@logout')->name('admin.logout');
	Route::get('home', 'Admin\HomeController@index')->name('admin.home');
});
