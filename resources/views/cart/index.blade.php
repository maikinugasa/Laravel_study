@extends('layouts.app_cart')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
@if (session('flash_message'))
	<div class="alert alert-{{ session('color') }}">
		{{ session('flash_message') }}
	</div>
@endif
@if($cart_count > 0)
<h2>カート内容</h2>
<div class="panel panel-default">
<table class="table">
<thead>
	<tr>
		<th scope="col">商品名</th>
		<th scope="col">値段</th>
		<th scope="col" colspan="2">購入数</th>
	</tr>
</thead>
<tbody>
	@foreach($carts as $cart)
	<tr>
		<td>{{ $cart->item->product_name }}</td>
		<td>{{ $cart->item->price }}</td>
		<td>{{ $cart->quantity }}</td>
		<td>
			<form action="{{ route('cart.destroy', ['id' => $cart->item->id]) }}" method="POST">
				{{ csrf_field() }}
				<input type="submit" value="削除" class="btn btn-danger btn-sm btn-dell">
			</form>
		</td>
	</tr>
	@endforeach
</tbody>
</table>
</div>
@else
<p style="text-align:center;">カートは空です</p>
@endif
</div>
</div>
</div>
@endsection