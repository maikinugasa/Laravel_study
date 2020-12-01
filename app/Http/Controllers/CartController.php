<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\facades\Auth;
use App\Cart;
use App\Item;

class CartController extends Controller
{
	//カート内容一覧
    public function index()
    {
		//$id = Auth::id();
		$user_id = Auth::id();
		//$item_id = DB::table('carts')->where('user_id', $user_id)->get();
		//$item_id = Cart::where('user_id', $user_id)->pluck('item_id');
		//$carts = (new Cart)->where('user_id', $user_id)->get();
		//$carts = (new Cart)->testget($user_id);
		$carts = Cart::where('user_id', $user_id)->get();
		$cart_count = $carts->count();
		//$items = DB::table('carts')->get();
		//dd($item_id);
		//$items = DB::table('items')->where('id', $item_id)->get(); //item_idから商品情報を取得
		//dd($carts);
		//return view('cart.index', compact('carts'));
		return view('cart.index')->with(['carts' => $carts, 'cart_count' => $cart_count]);
		//dd($items);
		//return view('cart.index')->with([
			//'cart' => $cart,
			//'items' => $items,
			//]);

		//dd($item_id);
		//return view('cart.index')->with('item', $item); //viewに渡す
    }
	//カート追加ボタン(要らない?)
    public function create()
    {
        //
    }

	//カート追加処理
    public function add(Request $request, $id)
    {
		$item = Item::where('id', $id)->first();
		if ($item->stock <= $request->input('quantity')) { //在庫数より購入数が上回る場合はエラー
			return redirect()->route('item.detail', ['id' => $item->id])->with([
				'flash_message' => '在庫が不足しています。購入数を変更してください。',
				'color' => 'danger'
			]);
		}
		//１、２の処理を同時処理
		DB::transaction(function() use($request, $id, $item) {
			/*--------------------------------------------------
				１.同じアイテムがカートに存在する場合は購入数を変更、
				存在しない場合は新規追加
			----------------------------------------------------*/
			$cart = Cart::firstOrNew([
				'user_id' => Auth::id(),
				'item_id' => $id,
			]);
			if ($cart->new) {
				$cart->quantity = $request->input('quantity');
			} else {
				//既存の購入数に追加分をadd
				$add_quantity = $cart->quantity + $request->input('quantity');
				$cart->quantity = $add_quantity;
			}
			$cart->save();
			/*--------------------------------------------------
				２.在庫数更新(現在の在庫数からカート追加分をマイナス)
			----------------------------------------------------*/
			$new_stock = $item->stock - $request->input('quantity');
			Item::where('id', $id)->update(['stock' => $new_stock]);
		});
		return redirect()->route('cart.index')->with([
			'flash_message' => 'カートに商品を追加しました。',
			'color' => 'success'
		]);

/*
		//$carts = Cart::where('user_id', Auth::id())->get();
		//$carts = Cart::where('user_id', Auth::id())->value('item_id')->first();
		$cart = Cart::where('item_id', $id)->where('user_id', Auth::id())->first();
		if (!empty($cart)) {
			$add_quantity = $carts->quantity + $request->input('quantity');
			$total = $add_quantity;
		} else {
			$total = $request->input('quantity');
		}
		$cart = new Cart;
		$cart->user_id =  Auth::id();
		$cart->item_id = $item->id;
		$cart->quantity = $total;
		$cart->save();

		if (Auth::id() == $user_id) {
			$quantity = Cart::where('item_id', $id)->value('quantity')->first();
			$add_quantity = $carts->quantity + $request->input('quantity');
			$total = $add_quantity;
		} else {
			$total = $request->input('quantity');
		//$total = $carts->quantity + $request->input('quantity');

		$cart = Cart::updateOrcreate(
			['user_id' => Auth::id(), 'item_id' => $id],
			[
			'user_id' => Auth::id(),
			'item_id' => $id,
			'quantity' => $total,
			]
		);
		if (0 < count(Cart::where('item_id', $carts->item_id) = $id));
			$new_quantity = $carts->quantity + $request->input('quantity');
			Cart::where('item_id', $id)->update(['quantity' => $new_quantity]);
		} else {
			$cart = new Cart;
			$cart->user_id =  Auth::id();
			$cart->item_id = $item->id;
			$cart->quantity = $request->input('quantity');
			$cart->save();
		}
		 */
    }
	//要らない
    public function show($id)
    {
        //
    }

	//購入数変更ボタン
    public function edit($id)
    {
        //
    }

	//購入数変更処理
    public function update(Request $request, $id)
    {
        //
    }

	//商品削除処理
    public function destroy(Request $request, $id)
    {
		//$cart = Cart::find($id);
		DB::transaction(function() use($request, $id) {
			//カートから商品削除
			$cart = Cart::where('user_id', Auth::id())->where('item_id', $id)->first();
			$cart->delete();
			//カートから削除した分の在庫数を戻す
			$item = Item::where('id', $id)->first();
			$total = $item->stock + $cart->quantity;
			$item->stock = $total;
			$item->save();
		});

		return redirect()->route('cart.index')->with([
			'flash_message' => '商品を削除しました',
			'color' => 'danger'
		]);
	}
}
