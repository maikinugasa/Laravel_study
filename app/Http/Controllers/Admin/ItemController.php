<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; //課題40で追加
use Illuminate\Support\Facades\Storage; //課題40で追加
use App\Item;
use App\Http\Requests\ItemRequest; //バリデーション

class ItemController extends Controller
{
	/*------------------------------------------------------
		商品一覧表示
	-------------------------------------------------------*/
	public function index()
	{
		$items = Item::paginate(10);
		return view('admin.index', compact('items')); //viewに渡す
	}

	/*------------------------------------------------------
		商品追加画面
	-------------------------------------------------------*/
	public function create()
	{
		return view('admin/create');
	}

	/*------------------------------------------------------
		商品追加処理
	-------------------------------------------------------*/
	public function store(ItemRequest $request)
	{
		$item = new Item;
		$item->product_name = $request->input('product_name');
		$item->description = $request->input('description');
		$item->price = $request->input('price');
		$item->stock = $request->input('stock');
		if (File::exists($request->file('pic'))) {
			$path = str_random(10); //ランダム値生成
			switch (exif_imagetype($request->file('pic'))) {
				case IMAGETYPE_GIF:
					$path .= '.gif';
					break;
				case IMAGETYPE_PNG:
					$path .= '.png';
					break;
				case IMAGETYPE_JPEG:
					$path .= '.jpg';
					break;
			}
			$item->pic = $path;
			//サーバー上に画像保存
			$request->pic->storeAs('public/item_pics', $path);
		}
		$item->save();
		return redirect()->route('admin.index')->with([
			'flash_message' => '商品の登録が完了しました',
			'color' => 'success'
		]);
	}

	/*------------------------------------------------------
		商品詳細画面
	-------------------------------------------------------*/
	public function detail($id)
	{
		$item = Item::findOrFail($id); //該当するidのレコードが見つからない場合例外を投げる
		if ($item->pic) {
			$path = $item->pic;
		}
		return view('admin.detail', compact('item', 'path')); //viewに渡す
	}

	/*------------------------------------------------------
		商品編集画面
	-------------------------------------------------------*/
	public function edit($id)
	{
		$item = Item::findOrFail($id); //該当するidのレコードが見つからない場合例外を投げる
		if ($item->pic) {
			$path = $item->pic;
		}
		return view('admin.edit', compact('item', 'path')); //viewに渡す
	}

	/*------------------------------------------------------
		商品編集処理
	-------------------------------------------------------*/
	public function update(ItemRequest $request, $id)
	{
		$item = Item::findOrFail($id); //該当するidのレコードが見つからない場合例外を投げる
		$current_pic = $item->pic;
		$item->product_name = $request->input('product_name');
		$item->description = $request->input('description');
		$item->price = $item['price']; //現在のデータ引き継ぎ
		$item->stock = $request->input('stock');
		if (File::exists($request->file('pic'))) {
			$path = str_random(10); //ランダム値生成
			switch (exif_imagetype($request->file('pic'))) {
				case IMAGETYPE_GIF:
					$path .= '.gif';
					break;
				case IMAGETYPE_PNG:
					$path .= '.png';
					break;
				case IMAGETYPE_JPEG:
					$path .= '.jpg';
					break;
			}
			$item->pic = $path;
			//サーバー上に画像保存
			$request->pic->storeAs('public/item_pics', $path);
			//既存で画像がある場合はサーバー上から削除
			if ($current_pic) {
				Storage::delete('public/item_pics/' . $current_pic);
			}
		}
		$item->save();
		return redirect()->route('admin.detail', ['id' => $item->id])->with([
			'flash_message' => '更新が完了しました',
			'color' => 'success'
		]);
	}

	/*------------------------------------------------------
		商品削除
	-------------------------------------------------------*/
	public function destroy(Request $request, $id)
	{
		$item = Item::findOrFail($id); //該当するidのレコードが見つからない場合例外を投げる
		$item->delete();
		return redirect()->route('admin.index')->with([
			'flash_message' => '商品を削除しました',
			'color' => 'success'
		]);
	}
}
