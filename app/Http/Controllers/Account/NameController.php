<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use Illuminate\Support\facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class NameController extends Controller
{
	//ユーザーネーム編集画面
    public function edit()
    {
		$user_id = Auth::id();
		$user = User::where('id', $user_id)->get()->first();
		return view('account.profile.name_edit', compact('user'));
    }
	//ユーザー名変更処理
    public function update(Request $request)
    {
		$user_id = Auth::id();
		$user = User::findOrFail($user_id); //該当するidのレコードが見つからない場合例外を投げる
		$pwd = $request->input('password');
		if (Hash::check($pwd, $user->password) == true) {
			$user->name = $request->input('name');
			$user->save();
			return redirect()->route('profile.index')->with([
				'flash_message' => 'ユーザー名の変更が完了しました',
				'color' => 'success'
			]);
		} else {
			return redirect()->route('name.edit')->with([
				'flash_message' => 'パスワードに誤りがあります',
				'color' => 'danger'
			]);
		}
    }
}
