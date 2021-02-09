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
@if($address_count > 0)
	<h2>お届け先住所選択</h2>
	<p><a href="{{ route('address.create') }}">新規配送先追加</a></p>
	<div class="panel panel-default">
	<table class="table">
	<thead>
		<tr>
			<th scope="col"></th>
			<th scope="col">氏名</th>
			<th scope="col">郵便番号</th>
			<th scope="col">住所</th>
			<th scope="col" colspan="2">電話番号</th>
		</tr>
	</thead>
	<tbody>
		@foreach($addresses as $address)
		<form action="{{ route('cart.confirm', $address->id) }}" method="GET">
			<tr>
				<td>
					<input type="radio" name="address" value="{{ $address->id }}">
				</td>
				<td>{{ $address->name }}</td>
				<td>〒{{ $address->postalcode }}</td>
				<td>{{ $address->prefecture }}{{ $address->city }}{{ $address->address }}</td>
				<td>{{ $address->phonenumber }}</td>
				<td>
					<a href="{{ route('address.edit', ['id' => $address->id]) }}">編集</a>
				</td>
			</tr>
		@endforeach
	</tbody>
	</table>
	</div>
	<p style="text-align:center;">
	<button type="submit" class="btn btn-primary btn-sm" style="font-size:18px;">
		次へ進む（内容確認)
	</button>
	</p>
	</form>
@else
	<div style="text-align:center;">
	<p>住所は未登録です<br>下記ボタンよりご登録ください</p>
	<p><a href="{{ route('address.create') }}" class="btn btn-primary btn-sm">新規配送先追加</a></p>
	</div>
@endif
</div>
</div>
<p style="text-align:center;"><a href="{{ route('cart.index') }}">前のページへ戻る</a></p>
</div>
@endsection
