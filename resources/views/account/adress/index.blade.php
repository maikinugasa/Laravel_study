@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
@if (session('flash_message'))
	<div class="alert alert-{{ session('color') }}">
		{{ session('flash_message') }}
	</div>
@endif
@if($adress_count > 0)
	<h2>登録住所</h2>
	<p><a href="{{ route('adress.create') }}" class="btn btn-primary btn-sm">新規配送先追加</a></p>
	<div class="panel panel-default">
	<table class="table">
	<thead>
		<tr>
			<th scope="col">No.</th>
			<th scope="col">氏名</th>
			<th scope="col">郵便番号</th>
			<th scope="col">住所</th>
			<th scope="col" colspan="2">電話番号</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 0; ?>
		@foreach($adresses as $adress)
		<?php $i++; ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td>{{ $adress->name }}</td>
				<td>〒{{ $adress->postalcode }}</td>
				<td>{{ $adress->prefecture }}{{ $adress->city }}{{ $adress->adress }}</td>
				<td>{{ $adress->phonenumber }}</td>
				<td>
					<a href="{{ route('adress.edit', ['id' => $adress->id]) }}" class="btn btn-primary btn-sm">編集</a>
				</td>
				<td>
					<form action="{{ route('adress.destroy', ['id' => $adress->id]) }}" method="POST">
						{{ csrf_field() }}
						<input type="submit" class="btn btn-danger btn-sm btn-dell" value="削除">
					</form>
				</td>
			</tr>
		@endforeach
	</tbody>
	</table>
	</div>
@else
	<p style="text-align:center;">住所は未登録です<br>下記ボタンよりご登録ください</p>
	<p style="text-align:center;"><a href="{{ route('adress.create') }}" class="btn btn-primary btn-sm">新規配送先追加</a></p>
@endif
</div>
</div>
<p style="text-align:center">
<a href="{{ route('account.index') }}">前のページへ戻る</a>
</p>
</div>
@endsection
