<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    //protected $redirectTo = '/home';
    protected $redirectTo = '/'; //ログイン後にhomeではなく商品一覧ページ(TOPページ)に飛ぶよう変更

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

	protected function guard()
	{
		return Auth::guard('user');
	}
	public function logout(Request $request)
	{
		Auth::guard('user')->logout();
		//ユーザーと管理者両方でログインしていた場合、userだけをログアウト(セッション削除)するよう設定
		$request->session()->forget('user');
		return redirect('/'); //ログアウト後のリダイレクト先
	}
}
