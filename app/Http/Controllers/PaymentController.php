<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;


class PaymentController extends Controller
{
	public function charge(Request $request)
	{
		//require_once('/home/hoge/stripe-php/init.php');
		try {
			Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
			$customer = Customer::create(array(
				'email' => $request->stripeEmail,
				'source' => $request->stripeToken
			));

			 $charge = Charge::create(array(
				 'customer' => $customer->id,
				 'amount' => 1000,
				 'currency' => 'jpy'
			 ));
			return back();
		} catch (\Exception $ex) {
			return $ex->getMessage();
		}
	}

}
