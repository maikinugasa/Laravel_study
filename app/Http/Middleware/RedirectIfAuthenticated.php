<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
	{
		//ログインや登録画面へアクセス時、既にログイン済みの場合のリダイレクトする先を設定
		if (Auth::guard($guard)->check()) {
			//下記4行追加
			//adminでのログイン時はadmin/homeへ
			if ($guard === 'admin') {
				return redirect('admin/home');
			} else {
				return redirect('/home');
			}
		}
		return $next($request);
	}
}
