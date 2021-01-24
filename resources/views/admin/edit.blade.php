@extends('layouts.app_admin')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">編集</div>
<div class="panel-body">
@if(!empty($path))
	<p style="text-align:center; margin:30px;"><img src="{{ asset('/storage/item_pics/' . $path) }}" alt="アイテム画像" height="100"></p>
@endif
<form class="form-horizontal" method="POST" action="{{ route('admin.update', ['id' => $item->id]) }}" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="form-group">
	<!---商品名-->
	<label for="product_name" class="col-md-4 control-label">商品名</label>
	<div class="col-md-6">
	<input id="product_name" type="text" class="form-control" name="product_name" value="{{ old('product_name', $item->product_name) }}" required autofocus>
	</div>
	</div>
	<!---商品説明-->
	<div class="form-group">
	<label for="description" class="col-md-4 control-label">商品説明</label>
	<div class="col-md-6">
	<textarea id="description" class="form-control" name="description">{{ old('description', $item->description) }}</textarea>
	</div>
	</div>
	<!---在庫数-->
	<div class="form-group">
	<label for="stock" class="col-md-4 control-label">在庫数</label>
	<div class="col-md-6">
	<input id="stock" type="text" class="form-control" name="stock" value="{{ old('stock', $item->stock) }}" required>
	</div>
	</div>
	<!---金額（hidden)-->
	<input type="hidden" name="price" value="{{ old('price', $item->price) }} ">
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
		更新する
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
