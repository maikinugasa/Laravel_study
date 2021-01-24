@extends('layouts.app_admin')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
@if(!empty($path))
	<p style="text-align:center;">
	<img src="{{ asset('/storage/item_pics/' . $path) }}" alt="アイテム画像" height="150">
	</p>
@endif
@if (session('flash_message'))
	<div class="alert alert-{{ session('color') }}">
		{{ session('flash_message') }}
	</div>
@endif
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
		<td>{{ $item->product_name }}</td>
		<td>{{ $item->description }}</td>
		<td>¥{{ $item->price }}</td>
		@empty($item->stock)
			<td>×在庫無し</td>
		@else
			<td>○在庫あり</td>
		@endempty
	</tr>
		<tr style="background:#F5F5F5;">
			<td></td>
			<td></td>
			<td style="text-align:right;">
				<a href="{{ route('admin.edit', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">編集する</a>
			</td>
			<td style="text-align:center;">
				<form action="{{ route('admin.destroy', ['id' => $item->id]) }}" method="POST">
					{{ csrf_field() }}
					<input type="submit" value="削除する" class="btn btn-danger btn-sm btn-dell">
				</form>
			</td>
		</tr>
</tbody>
</table>
</div>
<a href="{{ route('admin.index') }}">商品一覧へ戻る</a>
</div>
</div>
</div>
@endsection
