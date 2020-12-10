@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
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
					<li><a href="{{ route('adress.index') }}"> 登録住所設定</a></li>
					<li>ユーザー名変更(仮)</li>
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
					<li>パスワード設定(仮)</li>
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
