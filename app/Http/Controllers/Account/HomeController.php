<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('account.index');
    }
}
