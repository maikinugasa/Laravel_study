@extends('layouts.app_admin')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">編集</div>

				<div class="panel-body">
					<form class="form-horizontal" method="POST" action="{{ route('admin.update', ['id' => $item->id]) }}">
						{{ csrf_field() }}
							<!---商品名-->
							<label for="product_name" class="col-md-4 control-label">商品名</label>
							<div class="col-md-6">
								<br>
								<input id="product_name" type="text" class="form-control" name="product_name" value="{{ old('product_name', $item->product_name) }}" required autofocus>
							</div>
							<!---商品説明-->
							<label for="description" class="col-md-4 control-label">商品説明</label>
							<div class="col-md-6">
								<br>
								<textarea id="description" class="form-control" name="description">{{ old('description', $item->description) }}</textarea>
							</div>
							<!---在庫数-->
							<label for="stock" class="col-md-4 control-label">在庫数</label>
							<div class="col-md-6">
								<br>
								<input id="stock" type="text" class="form-control" name="stock" value="{{ old('stock', $item->stock) }}" required>
							</div>
							<!---金額（hidden)-->
								<input type="hidden" name="price" value="{{ old('price', $item->price) }} ">
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
@endsection
