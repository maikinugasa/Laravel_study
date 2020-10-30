<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Item;

class ItemController extends Controller
{
	public function index() {
		$items = Item::all();
		return view('index')->with('items', $items); //viewに渡す
	}
	public function detail($id) {
		$item = Item::findOrFail($id); //該当するidのレコードが見つからない場合例外を投げる
		return view('item.detail')->with('item', $item); //viewに渡す
	}
}
