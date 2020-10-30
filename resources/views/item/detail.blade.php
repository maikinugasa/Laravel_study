@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<table class="table">
<thead>
	<tr>
		<th scope="col">商品名</th>
		<th scope="col">商品説明</th>
		<th scope="col">値段</th>
		<th scope="col">在庫数</th>
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
<!--
		<td>{{$item[0]['product_name']}}</td>
		<td>{{$item[0]['description']}}</td>
		<td>{{$item[0]['price']}}yen</td>
-->
	</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
@endsection
