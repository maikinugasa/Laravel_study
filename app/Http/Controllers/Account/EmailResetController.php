<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use Illuminate\Support\facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;
use App\EmailReset;
use App\Notifications\EmailResetNotification;

class EmailResetController extends Controller
{
    public function index()
    {
    }
	//メールアドレス編集画面
    public function edit()
    {
		$user_id = Auth::id();
		$user = User::where('id', $user_id)->get()->first();
		return view('account.profile.email_edit', compact('user'));
    }
	//メールアドレス変更処理
    public function update(Request $request)
    {
		$user_id = Auth::id();
		$new_email = $request->input('email');
		$pwd = $request->input('password');
		//パスワード相違の場合はエラー
		$user = User::findOrFail($user_id); //該当するidのレコードが見つからない場合例外を投げる
		if (Hash::check($pwd, $user->password) == false) {
			return redirect()->route('email.edit')->with([
				'flash_message' => 'パスワードに誤りがあります',
				'color' => 'danger'
			]);
		}
		//既に登録されているメールアドレスの場合はエラー
		$resistered_email = User::where('email', $new_email)->where('id', $user_id)->first();
		if ($resistered_email) {
			return redirect()->route('email.edit')->with([
				'flash_message' => '既に登録済みのメールアドレスです',
				'color' => 'danger'
			]);
		}
		$token = hash_hmac('sha256', str_random(40) . $new_email, config('app.key'));
		$mail = new EmailReset;
		$mail->user_id = Auth::id();
		$mail->new_email = $new_email;
		$mail->token = $token;
		$mail->save();
		$mail->sendEmailResetNotification($token);
		$msg = "メールアドレスへ確認用URLを送信しました。\nお送りしたURLをクリックして、確認を完了してください。";
		return view('account.profile.email_update', compact('msg'));
    }
	//メール送信後のアドレス認証
    public function confirm($token)
    {
		//該当するtokenのレコードが見つからない場合はエラー
		$reset_data = EmailReset::where('token', $token)->get()->first();
		if (!$reset_data) {
			return \App::abort(404);
		}
		//該当するユーザーが見つからない場合はエラー
		$user = User::where('id', $reset_data->user_id)->get()->first();
		if (!$user) {
			return \App::abort(404);
		}
		//同じメールアドレスがUserテーブルに存在した場合はエラー(万一の不正アクセス防止)
		$new_email = $reset_data->new_email;
		$email_data = User::where('email', $new_email)->get()->count();
		if ($email_data > 0) {
			return \App::abort(404);
		}
		//(1)メールアドレス更新と(2)データ削除(3)セッション削除は同時処理
		DB::beginTransaction();
		try {
			//(1)メールアドレスの更新
			$user->email = $reset_data->new_email;
			$user->save();
			//(2)email_resetsのデータ削除
			EmailReset::where('token', $token)->delete();
			//(3)セッション削除(メールのurlから再度ログインさせるため)
			session()->flush();
			//データ操作を確定させる
			DB::commit();
		} catch(Exception $exception) {
			//データ操作を巻き戻す
			DB::rollBack();
			throw $exception;
		}
		return redirect('/login')->with([
		'flash_message' => 'メールアドレスの認証が完了しました。再度ログインしてください。',
			'color' => 'success'
		]);
	}
}
