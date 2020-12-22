<?php

namespace App\Http\Controllers\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\facades\Auth;
use App\Http\Requests\AdressRequest; //バリデーション
use App\User;
use App\Cart;
use App\Adress;

class AdressController extends Controller
{
	//登録住所一覧ページ
	public function index()
	{
		$user_id = Auth::id();
		$adresses = Adress::where('user_id', $user_id)->get();
		$adress_count = $adresses->count();
		return view('account.adress.index', compact('adresses' ,'adress_count'));
	}

	//住所登録ページ
	public function create()
	{
		$url = url()->previous();
		if ($url == 'https://procir-study.site/kinugasa351/exercise27/laravel_study/public/adress/choose') {
			$page = 'from_cart';
		} else {
			$page = 'from_account';
		}
		return view('account.adress.create', compact('page'));
	}

	//住所登録処理
	public function store(AdressRequest $request)
	{
		$user_id = Auth::id();
		$name = $request->input('name');
		$postalcode = $request->input('postalcode');
		$prefecture = $request->input('prefecture');
		$city = $request->input('city');
		$others = $request->input('adress');
		$phonenumber = $request->input('phonenumber');
		$page = $request->input('page');
		//既存で同じ住所がある場合はエラー
		$data = Adress::where('user_id', $user_id)
			->where('name', $name)
			->where('postalcode', $postalcode)
			->where('prefecture', $prefecture)
			->where('city', $city)
			->where('adress', $others)
			->where('phonenumber', $phonenumber)
			->first();
		if ($data) {
		//推移元によってリダイレクト先切り替え
			if ($page == 'from_cart') {
				return redirect()->route('adress.choose')->with([
					'flash_message' => '既に登録されている宛先です',
					'color' => 'danger'
				]);
			} elseif ($page == 'from_account') {
				return redirect()->route('adress.index')->with([
					'flash_message' => '既に登録されている宛先です',
					'color' => 'danger'
				]);
			}
		}
		//データの保存
		$adress = new Adress;
		$adress->user_id = $user_id;
		$adress->name = $name;
		$adress->postalcode = $postalcode;
		$adress->prefecture = $prefecture;
		$adress->city = $city;
		$adress->adress = $others;
		$adress->phonenumber = $phonenumber;
		$adress->save();
		//推移元によってリダイレクト先切り替え
		if ($page == 'from_cart') {
			return redirect()->route('adress.choose')->with([
				'flash_message' => '住所の登録が完了しました',
				'color' => 'success'
			]);
		} elseif ($page == 'from_account') {
			return redirect()->route('adress.index')->with([
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
		$adresses = Adress::where('user_id', $user_id)->get();
		$adress_count = $adresses->count();
		return view('account.adress.choose', compact('adresses', 'adress_count'));
	}

	//住所編集ページ
	public function edit(Request $request, $id)
	{
		$user_id = Auth::id();
		$adress_id = $request->id;
		$adress = Adress::where('id', $adress_id)->first();
		//住所データが存在しない場合エラー
		if (!$adress) {
			return \App::abort(404);
		}
		//住所データのユーザーとログインユーザー不一致の場合はエラー
		if ($adress->user_id != $user_id) {
			return \App::abort(404);
		}
		//推移先を分けるため前ページのurl情報を渡す
		$url = url()->previous();
		if ($url == 'https://procir-study.site/kinugasa351/exercise27/laravel_study/public/adress/choose') {
			$page = 'from_cart';//カートページからのリンク
		} else {
			$page = 'from_account';//アカウント設定ページからのリンク
		}
		$adress = Adress::find($id);
		return view('account.adress.edit', compact('page', 'adress'));
	}

	//住所編集処理
	public function update(AdressRequest $request, $id)
	{
		$adress = Adress::findOrFail($id); //該当するidのレコードが見つからない場合例外を投げる
		$user_id = Auth::id();
		//ユーザーが相違している場合はエラー
		if ($adress->user_id != $user_id) {
			return \App::abort(404);
		}
		$name = $request->input('name');
		$postalcode = $request->input('postalcode');
		$prefecture = $request->input('prefecture');
		$city = $request->input('city');
		$others = $request->input('adress');
		$phonenumber = $request->input('phonenumber');
		$page = $request->input('page');
		//既存で同じ住所がある場合はエラー
		$data = Adress::where('user_id', $user_id)
			->where('name', $name)
			->where('postalcode', $postalcode)
			->where('prefecture', $prefecture)
			->where('city', $city)
			->where('adress', $others)
			->where('phonenumber', $phonenumber)
			->first();
		if ($data) {
		//推移元によってリダイレクト先切り替え
			if ($page == 'from_cart') {
				return redirect()->route('adress.choose')->with([
					'flash_message' => '既に登録されている宛先です',
					'color' => 'danger'
				]);
			} elseif ($page == 'from_account') {
				return redirect()->route('adress.index')->with([
					'flash_message' => '既に登録されている宛先です',
					'color' => 'danger'
				]);
			}
		}
		//データ更新
		$adress->name = $name;
		$adress->postalcode = $postalcode;
		$adress->prefecture = $prefecture;
		$adress->city = $city;
		$adress->adress = $others;
		$adress->phonenumber = $phonenumber;
		$adress->save();
		//推移元によってリダイレクト先切り替え
		if ($page == 'from_cart') {
			return redirect()->route('adress.choose')->with([
				'flash_message' => '住所の変更が完了しました',
				'color' => 'success'
			]);
		} elseif ($page == 'from_account') {
			return redirect()->route('adress.index')->with([
				'flash_message' => '住所の変更が完了しました',
				'color' => 'success'
			]);
		}
	}

	//住所削除処理
	public function destroy(Request $request, $id)
	{
		$adress = Adress::findOrFail($id); //該当するidのレコードが見つからない場合例外を投げる
		$user_id = Auth::id();
		//ユーザーが相違している場合はエラー
		if ($adress->user_id != $user_id) {
			return \App::abort(404);
		}
		$adress->delete();
		return redirect()->route('adress.index')->with([
			'flash_message' => '住所を削除しました',
			'color' => 'success'
		]);
	}
}
