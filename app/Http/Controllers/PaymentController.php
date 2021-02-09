<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\facades\Auth;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use App\Payment;
use App\Purchase;
use App\PurchaseDetail;
use App\Address;
use App\Cart;
use App\Item;


class PaymentController extends Controller
{
	public function charge(Request $request)
	{
		$user_id = Auth::id();
		$carts = Cart::where('user_id', $user_id)->get();
		$result = 0;
		foreach ($carts as $cart) {
			$result += $cart->subtotal();
			$total = $result * 1.1;
		}
		$charge_id = null;
		try {
			Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
			$customer = Customer::create(array(
				'email' => $request->stripeEmail,
				'source' => $request->stripeToken
			));

			 $charge = Charge::create(array(
				 'customer' => $customer->id, //cus_から始まる顧客ID
				 'amount' => $total,
				 'currency' => 'jpy'
			 ));
			$charge_id = $charge->id;
			/*----------------------------------
				購入情報テーブル(purchase)の更新
			-------------------------------------*/

			//$requests->address_idで取ってきたidで住所の値をとる。ただしuser_idと一致しない場合は弾く
			$address_id = $request->address_id;
			$address = Address::where('id', $address_id)->where('user_id', Auth::id())->get()->first();
			if ($address) {
				$purchase = new Purchase;
				$purchase->user_id = Auth::id();
				$purchase->cus_id = $customer->id;
				$purchase->cus_name = $address->name;
				$purchase->postalcode = $address->postalcode;
				$purchase->address = $address->prefecture . $address->city . $address->address;
				$purchase->phonenumber = $address->phonenumber;
				$purchase->email = $customer->email;
				$purchase->status = "決済完了（発送待ち)";
				$purchase->save();
			}
			/*----------------------------------
				支払い情報詳細テーブル(purchase_details)の更新
			-------------------------------------*/
			$purchase = Purchase::where('cus_id', $customer->id)->get()->first();
			$purchase_id = $purchase->id;
			foreach ($carts as $cart) {
				$purchase_detail = new PurchaseDetail;
				$purchase_detail->purchase_id = $purchase_id;
				$purchase_detail->item_id = $cart->item_id;
				$purchase_detail->quantity = $cart->quantity;
				$purchase_detail->save();
			}
			/*----------------------------------
				支払い情報テーブル(payment)の更新
			-------------------------------------*/
			$payment = new Payment;
			$payment->user_id = $user_id;
			$payment->purchase_id = $purchase_id;
			$payment->transaction_id = $charge->id; //ch_から始まるチャージオブジェクトのID
			$payment->amount = $charge->amount;
			$payment->currency = $charge->currency;
			$payment->save();
			/*----------------------------------
				カート内容削除
			-------------------------------------*/
			Cart::where('user_id', $user_id)->delete();
			return redirect()->route('charged');
		} catch (\Exception $e) {
			if ($charge_id !== null) {
				\Stripe\Refund::create(array(
					'charge' => $charge->id,
				));
			}
			return redirect()->back()->with([
				'flash_message' => "決済に失敗しました。再度お試しください。",
				'color' => 'danger'
			]);
		}
	}
	public function charged(Request $request)
	{
		return view('cart.charged');
	}

}
