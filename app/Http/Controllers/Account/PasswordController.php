<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
//use App\Http\Requests\PasswordRequest; //バリデーション
use App\User;

class PasswordController extends Controller
{
	//パスワード編集画面
    public function edit()
    {
		$user_id = Auth::id();
		$user = User::where('id', $user_id)->get()->first();
		return view('account.security.password_edit', compact('user'));
    }
	//パスワード変更処理
    public function update(Request $request)
    {
		$user_id = Auth::id();
		$user = User::where('id', $user_id)->get()->first();
		$current_pwd = $request->input('current_pwd');//現在のパスワード
		$new_pwd = $request->input('new_pwd');//新しいパスワード
		$confirm_pwd = $request->input('confirm_pwd');//確認用パスワード
		//現在のパスワードが不一致の場合はエラー
		if (Hash::check($current_pwd, $user->password) == false) {
			return redirect()->route('password.edit')->with([
				'flash_message' => '現在のパスワードに誤りがあります',
				'color' => 'danger'
			]);
		}
		//新しいパスワードと確認用パスワードが不一致の場合はエラー
		if ($new_pwd != $confirm_pwd) {
			return redirect()->route('password.edit')->with([
				'flash_message' => '新しいパスワードと確認用パスワードが一致していません',
				'color' => 'danger'
			]);
		}
		//パスワードの変更がない場合はエラー
		if ($current_pwd == $new_pwd) {
			return redirect()->route('password.edit')->with([
				'flash_message' => 'パスワードを変更してください',
				'color' => 'danger'
			]);
		}
		//パスワード更新処理
		$user->password = bcrypt($request->input('new_pwd'));
		$user->save();
		return redirect()->route('account.index')->with([
			'flash_message' => 'パスワードを変更しました',
			'color' => 'success'
		]);
	}
}
