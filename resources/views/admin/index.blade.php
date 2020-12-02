@extends('layouts.app_admin')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">
@if (session('flash_message'))
	<div class="alert alert-{{ session('color') }}">
		{{ session('flash_message') }}
	</div>
@endif
<a href="{{ route('admin.create') }}">商品追加</a>
</div>
<div class="panel-body">
<table class="table">
<thead>
	<tr>
		<th scope="col">商品名</th>
		<th scope="col">値段</th>
		<th scope="col" colspan="3">在庫状況</th>
	</tr>
</thead>
<tbody>
@foreach($items as $item)
	<tr>
		<td>
			<a href="{{ route('admin.detail', ['id' => $item->id]) }}">{{ $item->product_name }}</a>
		</td>
		<td>¥{{ $item->price }}</td>
		@empty($item->stock)
			<td>×在庫無し</td>
		@else
			<td>○在庫あり</td>
		@endempty
		<td>
			<a href="{{ route('admin.edit', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">編集</a>
		</td>
		<td>
			<form action="{{ route('admin.destroy', ['id' => $item->id]) }}" method="POST">
				{{ csrf_field() }}
				<input type="submit" value="削除" class="btn btn-danger btn-sm btn-dell">
			</form>
		</td>
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
