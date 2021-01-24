<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; //課題40で追加
use Illuminate\Support\Facades\Storage; //課題40で追加
use App\Item;

class ItemController extends Controller
{
/*--------------------------------
	ユーザー用アイテム一覧
---------------------------------*/
	public function index() {
		$items = Item::paginate(10);
		return view('index')->with('items', $items); //viewに渡す
	}
	public function detail($id) {
		$item = Item::findOrFail($id); //該当するidのレコードが見つからない場合例外を投げる
		if ($item->pic) {
			$path = $item->pic;
		}
		return view('item.detail', compact('item', 'path')); //viewに渡す
	}
}
