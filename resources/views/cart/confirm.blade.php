@extends('layouts.app_cart')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
@if ($errors->any())
	<div class="alert alert-danger">
	<ul>
	@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
	@endforeach
	</ul>
	</div>
@endif
	<h2>ご注文内容確認</h2>
	<table class="table">
	<thead>
		<tr>
			<th colspan="3">注文内容</th>
		</tr>
	</thead>
	<tbody>
		@foreach($carts as $cart)
			<tr>
				<td>{{ $cart->item->product_name }}</td>
				<td>×{{ $cart->quantity }}</td>
				<td style="color:brown;">¥{{ $cart->item->price * $cart->quantity }}</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3" style="font-weight:bold;text-align:right;">お支払い金額：¥{{ $total }}(税込)</td>
		</tr>
	</tfoot>
	</table>
</div>
<div class="panel panel-default">
	<table class="table">
	<thead>
		<tr>
			<th scope="col" colspan="3">お届け先</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ $address->name }}</td>
			<td>
				〒{{ $address->postalcode }}<br>
				{{ $address->prefecture }}
				{{ $address->city }}
				{{ $address->address }}
			</td>
			<td>{{ $address->phonenumber }}</td>
		</tr>
	</tbody>
	</table>
</div>
<div style="text-align:center;">
<div class="content">
<form action="{{ route('charge') }}" method="POST">
{{ csrf_field() }}
<input type="hidden" name="address_id" value="{{ $address_id }}">
<script
src="https://checkout.stripe.com/checkout.js"
class="stripe-button"
data-key="pk_test_51IE3apFoNyHqXHW2IQmpjUxaZr4oBpG7UTFDaXm9mAlp1CYI03q1MjrJKfQdnkEpXswqcDemNmVQV8Kn8cBwOLYc007ekaQcqX"
data-amount="{{ $total }}"
data-name="決済画面"
data-description="カード情報を入力ください"
data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
data-locale="auto"
data-allow-remember-me="false"
data-label="決済画面へ進む"
data-currency="jpy">
</script>
</form>
</div>
<br>
<p><a href="{{ route('address.choose') }}">前のページへ戻る</a></p>
</div>
</div>
</div>
@endsection
