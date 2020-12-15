<?php

namespace App\Http\Controllers\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\facades\Auth;
//use App\Http\Requests\AdressRequest; //バリデーション
use App\User;
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
    public function store(Request $request)
    {
		$adress = new Adress;
		$adress->user_id = Auth::id();
		$adress->name = $request->input('name');
		$adress->postalcode = $request->input('postalcode');
		$adress->prefecture = $request->input('prefecture');
		$adress->city = $request->input('city');
		$adress->adress = $request->input('adress');
		$adress->phonenumber = $request->input('phonenumber');
		$adress->save();
		//推移元によってリダイレクト先切り替え
		$page = $request->input('page');
		if ($page == 'from_cart') {
			return redirect()->route('adress.choose');
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
		$adresses = Adress::where('user_id', $user_id)->get();
		$adress_count = $adresses->count();
		return view('account.adress.choose', compact('adresses' ,'adress_count'));
    }

	//住所編集ページ
    public function edit($id)
    {
        //
    }

	//住所編集処理
    public function update(Request $request, $id)
    {
        //
    }

	//住所削除処理
    public function destroy(Request $request, $id)
    {
		$adress = Adress::find($id);
		$adress->delete();
		return redirect()->route('adress.index')->with([
			'flash_message' => '住所を削除しました',
			'color' => 'success'
		]);
    }
}
