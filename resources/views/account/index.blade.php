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
	<h2> 会員情報</h2>
	<div class="panel panel-default">
	<table class="table">
	<thead>
		<tr><td>■お客様情報の確認・変更</td></tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<ul>
					<li><a href="{{ route('address.index') }}"> 登録住所設定</a></li>
					<li><a href="{{ route('profile.index') }}"> プロフィール情報変更</li>
				</ul>
			</td>
		<tr>
	</tbody>
	</table>
	<table class="table">
	<thead>
		<tr><td>■セキュリティ</td></tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<ul>
					<li><a href="{{ route('password.edit') }}">パスワード変更</a></li>
				</ul>
			</td>
		<tr>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
@endsection
