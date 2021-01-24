@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
@if(!empty($path))
	<p style="text-align:center;">
	<img src="{{ asset('/storage/item_pics/' . $path) }}" alt="アイテム画像" height="150">
	</p>
@endif
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
		@if(!empty($item->stock))
			@if (Auth::user())
			<td>
				<form action="{{ route('cart.add', ['id' => $item->id]) }}" method="POST">
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
			@else
				<td>ログインしてください</td>
			@endif
		@else
			<td>在庫無し</td>
		@endif
	</tr>
</tbody>
</table>
</div>
<a href="javascript:history.back()">前のページへ戻る</a>
</div>
</div>
</div>
@endsection
