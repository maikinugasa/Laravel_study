@extends('layouts.app_cart')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
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
			<td>{{ $adress->name }}</td>
			<td>
				〒{{ $adress->postalcode }}<br>
				{{ $adress->prefecture }}
				{{ $adress->city }}
				{{ $adress->adress }}
			</td>
			<td>{{ $adress->phonenumber }}</td>
		</tr>
	</tbody>
	</table>
</div>
<div style="text-align:center;">
	<p><a href="null" class="btn btn-primary btn-sm" style="font-size:18px;">決済へ進む(仮)</a></p>
	<p><a href="{{ route('adress.choose') }}">前のページへ戻る</a></p>
</div>
</div>
</div>
@endsection
