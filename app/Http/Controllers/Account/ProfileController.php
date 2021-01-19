<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use Illuminate\Support\facades\Auth;
use App\User;

class ProfileController extends Controller
{
	//ユーザー情報表示画面
    public function index()
    {
		$user_id = Auth::id();
		$user = User::where('id', $user_id)->get();
		return view('account.profile.index', compact('user'));
    }
}
