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
<div class="panel-heading">商品一覧</div>
<div class="panel-body">
<table class="table">
<thead>
	<tr>
		<th scope="col">商品名</th>
		<th scope="col">値段</th>
		<th scope="col">在庫状況</th>
	</tr>
</thead>
<tbody>
	@foreach($items as $item)
		<tr>
			<td><a href="{{action('ItemController@detail', $item->id)}}">{{$item->product_name}}</a></td>
			<td>{{$item->price}}yen</td>
			@empty($item->stock)
				<td>×在庫無し</td>
			@else
				<td>○在庫あり</td>
			@endempty
		</tr>
	@endforeach
</tbody>
</table>
 {{ $items->links() }}
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
