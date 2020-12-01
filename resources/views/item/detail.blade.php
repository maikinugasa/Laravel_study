@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
@if (session('flash_message'))
	<div class="alert alert-{{ session('color') }}">
		{{ session('flash_message') }}
	</div>
@endif
<table class="table">
<thead>
	<tr>
		<th scope="col">商品名</th>
		<th scope="col">商品説明</th>
		<th scope="col">値段</th>
		<th scope="col" colspan="2">在庫数</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td>{{$item->product_name}}</td>
		<td>{{$item->description}}</td>
		<td>{{$item->price}}</td>
		@empty($item->stock)
			<td>×在庫無し</td>
		@else
			<td>○在庫あり</td>
		@endempty
		@if (Auth::user())
			@if(!empty($item->stock))
			<td>
				<form action="{{ route('cart.add', ['id'=>$item->id]) }}" method="POST">
					{{ csrf_field() }}
					<select name="quantity">
					<option value="1" selected>1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					</select>
					<input type="submit" value="カートに追加する" class="btn btn-primary btn-sm btn-dell">
				</form>
			</td>
			@endif
		@endif
	</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
@endsection
