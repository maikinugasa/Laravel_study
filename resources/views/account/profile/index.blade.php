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
	<h2>プロフィール情報</h2>
	<div class="panel panel-default">
	<table class="table">
		@foreach($user as $info)
		<tr>
			<th scope="col" style="color:#888888;">氏名</th>
			<td>{{ $info->name }}</td>
				<td>
					<a href="{{ route('name.edit') }}" class="btn btn-primary btn-sm">編集</a>
				</td>
		</tr>
		<tr>
			<th scope="col" style="color:#888888;">メールアドレス</th>
			<td>{{ $info->email }}</td>
				<td>
					<a href="{{ route('email.edit') }}" class="btn btn-primary btn-sm">編集</a>
				</td>
		</tr>
		@endforeach
	</table>
	</div>
</div>
</div>
<p style="text-align:center">
<a href="{{ route('account.index') }}">前のページへ戻る</a>
</p>
</div>
@endsection
