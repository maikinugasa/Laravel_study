<?php

namespace App\Http\Controllers\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\facades\Auth;
use App\Http\Requests\AddressRequest; //バリデーション
use App\User;
use App\Cart;
use App\Address;

class AddressController extends Controller
{
	//登録住所一覧ページ
	public function index()
	{
		$user_id = Auth::id();
		$addresses = Address::where('user_id', $user_id)->get();
		$address_count = $addresses->count();
		return view('account.address.index', compact('addresses' ,'address_count'));
	}

	//住所登録ページ
	public function create()
	{
		$url = url()->previous();
		if ($url == 'https://procir-study.site/kinugasa351/exercise27/laravel_study/public/address/choose') {
			$page = 'from_cart';
		} else {
			$page = 'from_account';
		}
		return view('account.address.create', compact('page'));
	}

	//住所登録処理
	public function store(AddressRequest $request)
	{
		$user_id = Auth::id();
		$name = $request->input('name');
		$postalcode = $request->input('postalcode');
		$prefecture = $request->input('prefecture');
		$city = $request->input('city');
		$others = $request->input('address');
		$phonenumber = $request->input('phonenumber');
		$page = $request->input('page');
		//既存で同じ住所がある場合はエラー
		$data = Address::where('user_id', $user_id)
			->where('name', $name)
			->where('postalcode', $postalcode)
			->where('prefecture', $prefecture)
			->where('city', $city)
			->where('address', $others)
			->where('phonenumber', $phonenumber)
			->first();
		if ($data) {
			//推移元によってリダイレクト先切り替え
			if ($page == 'from_cart') {
				return redirect()->route('address.choose')->with([
					'flash_message' => '既に登録されている宛先です',
					'color' => 'danger'
				]);
			} elseif ($page == 'from_account') {
				return redirect()->route('address.index')->with([
					'flash_message' => '既に登録されている宛先です',
					'color' => 'danger'
				]);
			}
		}
		//データの保存
		$address = new Address;
		$address->user_id = $user_id;
		$address->name = $name;
		$address->postalcode = $postalcode;
		$address->prefecture = $prefecture;
		$address->city = $city;
		$address->address = $others;
		$address->phonenumber = $phonenumber;
		$address->save();
		//推移元によってリダイレクト先切り替え
		if ($page == 'from_cart') {
			return redirect()->route('address.choose')->with([
				'flash_message' => '住所の登録が完了しました',
				'color' => 'success'
			]);
		} elseif ($page == 'from_account') {
			return redirect()->route('address.index')->with([
				'flash_message' => '住所の登録が完了しました',
				'color' => 'success'
			]);
		}
	}

	//住所選択ページ
	public function choose()
	{
		$user_id = Auth::id();
		//カート内にアイテムが無い場合はアクセス拒否
		$carts = Cart::where('user_id', $user_id)->first();
		if (!$carts) {
			return \App::abort(404);
		}
		$addresses = Address::where('user_id', $user_id)->get();
		$address_count = $addresses->count();
		return view('account.address.choose', compact('addresses', 'address_count'));
	}

	//住所編集ページ
	public function edit(Request $request, $id)
	{
		$user_id = Auth::id();
		$address_id = $request->id;
		$address = Address::where('id', $address_id)->first();
		//住所データが存在しない場合エラー
		if (!$address) {
			return \App::abort(404);
		}
		//住所データのユーザーとログインユーザー不一致の場合はエラー
		if ($address->user_id != $user_id) {
			return \App::abort(404);
		}
		//推移先を分けるため前ページのurl情報を渡す
		$url = url()->previous();
		if ($url == 'https://procir-study.site/kinugasa351/exercise27/laravel_study/public/address/choose') {
			$page = 'from_cart';//カートページからのリンク
		} else {
			$page = 'from_account';//アカウント設定ページからのリンク
		}
		$address = Address::find($id);
		return view('account.address.edit', compact('page', 'address'));
	}

	//住所編集処理
	public function update(AddressRequest $request, $id)
	{
		$address = Address::findOrFail($id); //該当するidのレコードが見つからない場合例外を投げる
		$user_id = Auth::id();
		//ユーザーが相違している場合はエラー
		if ($address->user_id != $user_id) {
			return \App::abort(404);
		}
		$name = $request->input('name');
		$postalcode = $request->input('postalcode');
		$prefecture = $request->input('prefecture');
		$city = $request->input('city');
		$others = $request->input('address');
		$phonenumber = $request->input('phonenumber');
		$page = $request->input('page');
		//既存で同じ住所がある場合はエラー
		$data = Address::where('user_id', $user_id)
			->where('name', $name)
			->where('postalcode', $postalcode)
			->where('prefecture', $prefecture)
			->where('city', $city)
			->where('address', $others)
			->where('phonenumber', $phonenumber)
			->first();
		if ($data) {
			if ($id != $data->id) { //同一ID以外の被りだけエラー
				//推移元によってリダイレクト先切り替え
				if ($page == 'from_cart') {
					return redirect()->route('address.choose')->with([
						'flash_message' => '既に登録されている宛先です',
						'color' => 'danger'
					]);
				} elseif ($page == 'from_account') {
					return redirect()->route('address.index')->with([
						'flash_message' => '既に登録されている宛先です',
						'color' => 'danger'
					]);
				}
			}
		}
		//データ更新
		$address->name = $name;
		$address->postalcode = $postalcode;
		$address->prefecture = $prefecture;
		$address->city = $city;
		$address->address = $others;
		$address->phonenumber = $phonenumber;
		$address->save();
		//推移元によってリダイレクト先切り替え
		if ($page == 'from_cart') {
			return redirect()->route('address.choose')->with([
				'flash_message' => '住所の変更が完了しました',
				'color' => 'success'
			]);
		} elseif ($page == 'from_account') {
			return redirect()->route('address.index')->with([
				'flash_message' => '住所の変更が完了しました',
				'color' => 'success'
			]);
		}
	}

	//住所削除処理
	public function destroy(Request $request, $id)
	{
		$address = Address::findOrFail($id); //該当するidのレコードが見つからない場合例外を投げる
		$user_id = Auth::id();
		//ユーザーが相違している場合はエラー
		if ($address->user_id != $user_id) {
			return \App::abort(404);
		}
		$address->delete();
		return redirect()->route('address.index')->with([
			'flash_message' => '住所を削除しました',
			'color' => 'success'
		]);
	}
}
