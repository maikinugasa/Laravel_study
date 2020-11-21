<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Item;
use App\Http\Requests\ItemRequest; //バリデーション

class ItemController extends Controller
{
	/*------------------------------------------------------
		商品一覧表示
	-------------------------------------------------------*/
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$items = Item::paginate(10);
		return view('admin.index')->with('items', $items); //viewに渡す
	}

	/*------------------------------------------------------
		商品追加画面
	-------------------------------------------------------*/
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin/create');
	}

	/*------------------------------------------------------
		商品追加処理
	-------------------------------------------------------*/
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(ItemRequest $request)
	{
		$item = new Item;
		$item->product_name = $request->input('product_name');
		$item->description = $request->input('description');
		$item->price = $request->input('price');
		$item->stock = $request->input('stock');
		$item->save();
		return redirect('admin/index')->with([
			'flash_message' => '商品の登録が完了しました',
			'color' => 'success'
		]);
	}

	/*------------------------------------------------------
		商品詳細画面
	-------------------------------------------------------*/
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function detail($id)
	{
		$item = Item::findOrFail($id); //該当するidのレコードが見つからない場合例外を投げる
		return view('admin.detail')->with('item', $item); //viewに渡す
	}

	/*------------------------------------------------------
		商品編集画面
	-------------------------------------------------------*/
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$item = Item::find($id); //idで情報取得
		return view('admin.edit')->with('item', $item); //viewに渡す
	}

	/*------------------------------------------------------
		商品編集処理
	-------------------------------------------------------*/
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(ItemRequest $request, $id)
	{
		$item = Item::find($id);
		$item->product_name = $request->input('product_name');
		$item->description = $request->input('description');
		$item->price = $item['price']; //現在のデータ引き継ぎ
		$item->stock = $request->input('stock');
		$item->save();
		return redirect()->route('admin.detail', ['id' => $item->id])->with([
			'flash_message' => '更新が完了しました',
			'color' => 'success'
		]);
	}

	/*------------------------------------------------------
		商品削除
	-------------------------------------------------------*/
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		$item = Item::find($id);
		$item->delete();
		return redirect('admin/index')->with([
			'flash_message' => '商品を削除しました',
			'color' => 'success'
		]);
	}
}
