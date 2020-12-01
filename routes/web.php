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
Route::get('/', 'ItemController@index')->name('index');
//商品詳細画面へ
Route::get('item/detail/{id}', 'ItemController@detail')->name('item.detail');


/*------------------------------------
	User 認証不要のページ(ホーム)
--------------------------------------*/
Route::get('/', 'ItemController@index');
/*------------------------------------
	User 認証要のページ(ログアウト・カート機能)
--------------------------------------*/
Route::group(['middleware' => 'auth:user'], function() {
	Route::post('logout','Auth\LoginController@logout')->name('logout');
	Route::get('cart/index', 'CartController@index')->name('cart.index');
	Route::post('cart/add/{id}', 'CartController@add')->name('cart.add'); //カート追加処理
	Route::post('cart/destroy/{id}', 'CartController@destroy')->name('cart.destroy'); //カート内商品削除処理
});
/*------------------------------------
	Admin 認証不要のページ(ログイン)
--------------------------------------*/
Route::group(['prefix' => 'admin'], function() {
	Route::get('login','Admin\Auth\LoginController@showLoginForm')->name('admin.login');
	Route::post('login','Admin\Auth\LoginController@login');
});

/*------------------------------------
	Admin 認証要のページ(管理者用ホーム・商品管理・ログアウト)
--------------------------------------*/
//config/auth.phpで指定したguardsで認証されたユーザーだけにアクセス許可
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
	Route::post('logout','Admin\Auth\LoginController@logout')->name('admin.logout');
	Route::get('home', 'Admin\HomeController@index')->name('admin.home');
	Route::get('index', 'Admin\ItemController@index')->name('admin.index'); //商品一覧ページ(管理者TOPページ)
	Route::get('item/detail/{id}', 'Admin\ItemController@detail')->name('admin.detail'); //商品詳細ページ
	Route::get('item/create', 'Admin\ItemController@create')->name('admin.create'); //商品追加ページ
	Route::post('item/store', 'Admin\ItemController@store')->name('admin.store'); //商品追加処理
	Route::get('item/edit/{id}', 'Admin\ItemController@edit')->name('admin.edit'); //商品編集ページ
	Route::post('item/update/{id}', 'Admin\ItemController@update')->name('admin.update'); //商品編集の更新処理
	Route::post('item/destroy/{id}', 'Admin\ItemController@destroy')->name('admin.destroy'); //商品削除処理
});
