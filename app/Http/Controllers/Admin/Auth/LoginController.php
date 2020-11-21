<?php

namespace App\Http\Controllers\Admin\Auth; //修正

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		//ログアウトはログイン後に実行出来るようexceptに設定する
        $this->middleware('guest:admin')->except('logout'); //変更
    }
	//下記追加(課題33)
	//ログイン画面をviewに表示
	public function showLoginForm(Request $request)
	{
		return view('admin.login');
	}
	protected function guard()
	{
		return Auth::guard('admin');
	}
	public function logout(Request $request)
	{
		Auth::guard('admin')->logout();
		//ユーザーと管理者両方でログインしていた場合、adminだけをログアウト(セッション削除)するよう設定
		$request->session()->forget('admin');
		return redirect('/admin/login'); //ログアウト後のリダイレクト先
	}

}
