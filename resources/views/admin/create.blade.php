@extends('layouts.app_admin')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">商品追加</div>
<div class="panel-body">
<form class="form-horizontal" method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data">
	{{ csrf_field() }}
	<!---商品名-->
	<div class="form-group">
	<label for="product_name" class="col-md-4 control-label">商品名</label>
	<div class="col-md-6">
	<input id="product_name" type="text" class="form-control" name="product_name" value="{{ old('product_name') }}" required autofocus>
	</div>
	</div>
	<!---商品説明-->
	<div class="form-group">
	<label for="description" class="col-md-4 control-label">商品説明</label>
	<div class="col-md-6">
	<textarea id="description" class="form-control" name="description">{{ old('description') }}</textarea>
	</div>
	</div>
	<!---金額-->
	<div class="form-group">
	<label for="price" class="col-md-4 control-label">金額</label>
	<div class="col-md-6">
	<input id="price" type="text" class="form-control" name="price" value="{{ old('price') }}" required>
	</div>
	</div>
	<!---在庫数-->
	<div class="form-group">
	<label for="stock" class="col-md-4 control-label">在庫数</label>
	<div class="col-md-6">
	<input id="stock" type="text" class="form-control" name="stock" value="{{ old('stock') }}" required>
	</div>
	</div>
	<!--画像-->
	<div class="col-md-6">
	<p style="margin-left:240px; margin-top:30px;">
	<input id="pic" type="file" name="pic">
	</p>
	</div>
	<div class="form-group">
	<div class="col-md-6 col-md-offset-4">
	<br>
	@if ($errors->any())
		<div class="alert alert-danger">
		<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
		</div>
	@endif
	<button type="submit" class="btn btn-primary">
		登録
	</button>
	<br>
	<a href="{{ action('Admin\ItemController@index') }}">商品一覧へ戻る</a>
	</div>
	</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
