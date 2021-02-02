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
<div class="panel-body">
<table class="table">
<thead>
	<tr>
		<th scope="col">ユーザー名</th>
		<th scope="col">メールアドレス</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td>{{ $user->name }}</td>
		<td>{{ $user->email }}</td>
	</tr>
</tbody>
</table>
</div>
</div>
</div>

<h4>【お届け先住所】</h4>
	<div class="panel panel-default">
@if($address_count > 0)
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
		@foreach($addresses as $address)
		<?php $i++; ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td>{{ $address->name }}</td>
				<td>〒{{ $address->postalcode }}</td>
				<td>{{ $address->prefecture }}{{ $address->city }}{{ $address->address }}</td>
				<td>{{ $address->phonenumber }}</td>
			</tr>
		@endforeach
	</tbody>
	</table>
@else
	<p style="text-align:center;">未登録</p>
@endif
</div>
<a href="{{ route('admin.users') }}">会員一覧へ戻る</a>
</div>
</div>
</div>
@endsection
