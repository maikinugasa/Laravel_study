<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\facades\Auth;
use App\Http\Requests\CartRequest; //バリデーション
use App\Cart;
use App\Item;

class CartController extends Controller
{
	//カート内容一覧
	public function index()
	{
		$user_id = Auth::id();
		$carts = Cart::where('user_id', $user_id)->get();
		$cart_count = $carts->count();
		$each_price = $this->eachprice($carts);
		$subtotal = $this->subtotals($carts); //subtotalsの計算式呼び出し
		//dd($each_price);
		$tax = $subtotal * 0.1;
		$total = $subtotal + $tax;
		return view('cart.index', compact('each_price', 'carts', 'cart_count', 'subtotal', 'tax', 'total'));
	}
	public function eachprice($carts) {
		foreach ($carts as $cart) {
			$result = $cart->subtotal(); //Model内の計算式subtotalを呼び出し→全てを足し
		}
		return $result;
	}
	//合計金額計算
	public function subtotals($carts) {
		$result = 0; //初期値
		foreach ($carts as $cart) {
			$result += $cart->subtotal(); //Model内の計算式subtotalを呼び出し→全てを足し
		}
		return $result;
	}

	//カート追加処理
	public function add(CartRequest $request, $id)
	{
		$item = Item::where('id', $id)->first();
		if (!$item) {
			return \App::abort(404);
		}
		if ($item->stock < $request->input('quantity')) { //在庫数より購入数が上回る場合はエラー
			return redirect()->route('item.detail', ['id' => $item->id])->with([
				'flash_message' => '在庫が不足しています。購入数を変更してください。',
				'color' => 'danger'
			]);
		}
		//１、２を同時処理
		DB::transaction(function() use($request, $id, $item) {
			/*--------------------------------------------------
				１.同じアイテムがカートに存在する場合は購入数を変更、
				存在しない場合は新規追加
			----------------------------------------------------*/
			$cart = Cart::firstOrNew(['user_id' => Auth::id(), 'item_id' => $id]);
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
	}

	//商品削除処理
	public function destroy(Request $request, $id)
	{
		//１、２を同時処理
		DB::transaction(function() use($request, $id) {
			//１.カートから商品削除
			$cart = Cart::where('user_id', Auth::id())->where('item_id', $id)->first();
			if (!$cart) {
				return \App::abort(404);
			}
			$cart->delete();
			//２.カートから削除した分の在庫数を戻す
			$item = Item::where('id', $id)->first();
			if (!$item) {
				return \App::abort(404);
			}
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
