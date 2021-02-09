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

Route::get('/', 'ItemController@index')->name('index');
//商品詳細画面へ
Route::get('item/detail/{id}', 'ItemController@detail')->name('item.detail');


/*------------------------------------
	User 認証不要のページ(ホーム)
--------------------------------------*/
Route::get('/', 'ItemController@index');
Route::get('profile/email/confirm/{token}', 'Account\EmailResetController@confirm')->name('email.confirm'); //メールアドレス編集ページ
/*------------------------------------
	User 認証要のページ(ログアウト・カート機能・配送先住所)
--------------------------------------*/
Route::group(['middleware' => 'auth:user'], function() {
	Route::post('logout','Auth\LoginController@logout')->name('logout');
	Route::get('cart/index', 'CartController@index')->name('cart.index');
	Route::post('cart/add/{id}', 'CartController@add')->name('cart.add'); //カート追加処理
	Route::post('cart/destroy/{id}', 'CartController@destroy')->name('cart.destroy'); //カート内商品削除処理
	Route::get('account/index', 'Account\HomeController@index')->name('account.index'); //後々その他のアカウント設定ページを作った時用（現在は住所情報のみ)
	Route::get('address/index', 'Account\AddressController@index')->name('address.index'); //登録住所一覧表示
	Route::post('address/destroy/{id}', 'Account\AddressController@destroy')->name('address.destroy'); //登録住所削除処理
	Route::get('address/create', 'Account\AddressController@create')->name('address.create'); //新規住所登録ページ
	Route::get('address/edit/{id}', 'Account\AddressController@edit')->name('address.edit'); //住所編集ページ
	Route::post('address/update/{id}', 'Account\AddressController@update')->name('address.update'); //住所編集の更新処理
	Route::post('address/store', 'Account\AddressController@store')->name('address.store'); //住所登録処理
	Route::post('address/destroy/{id}', 'Account\AddressController@destroy')->name('address.destroy'); //商品削除処理
	Route::get('address/choose', 'Account\AddressController@choose')->name('address.choose'); //住所選択ページ
	//Route::post('cart/confirm', 'CartController@confirm')->name('cart.confirm'); //内容確認ページ
	Route::get('cart/confirm/', 'CartController@confirm')->name('cart.confirm'); //内容確認ページ
	Route::get('profile/index', 'Account\ProfileController@index')->name('profile.index'); //ユーザー情報表示画面
	Route::get('profile/name/edit', 'Account\NameController@edit')->name('name.edit'); //ユーザー名編集ページ
	Route::post('profile/name/update', 'Account\NameController@update')->name('name.update'); //ユーザー名の変更処理
	Route::get('profile/email/edit', 'Account\EmailResetController@edit')->name('email.edit'); //メールアドレス編集ページ
	Route::post('profile/email/update', 'Account\EmailResetController@update')->name('email.update'); //メールアドレスの変更処理(送信完了メッセージ表示)
	Route::get('security/password/edit', 'Account\PasswordController@edit')->name('password.edit'); //パスワード編集ページ
	Route::post('security/password/update', 'Account\PasswordController@update')->name('password.update'); //パスワード変更処理
	Route::post('cart/charge', 'PaymentController@charge')->name('charge'); //決済処理
	Route::get('cart/charged', 'PaymentController@charged')->name('charged'); //決済完了画面
});
/*------------------------------------
	Admin 認証不要のページ(管理者用ログイン)
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
	Route::get('users', 'Admin\UserForAdminController@index')->name('admin.users'); //ユーザー一覧ページ
	Route::get('users/detail/{id}', 'Admin\UserForAdminController@detail')->name('admin.users.detail'); //ユーザー詳細ページ
});
