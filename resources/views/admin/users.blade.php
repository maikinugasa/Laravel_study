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
		<th scope="col">会員一覧</th>
	</tr>
</thead>
<tbody>
@foreach($users as $user)
	<tr>
		<td>
			<a href="{{ route('admin.users.detail', ['id' => $user->id]) }}">{{ $user->name }}</a>
		</td>
	</tr>
@endforeach
</tbody>
</table>
 {{ $users->links() }}
<p><a href="{{ route('admin.index') }}">商品一覧へ戻る</a></p>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
