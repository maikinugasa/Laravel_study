@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">お届け先住所変更</div>

				<div class="panel-body">
					<form class="form-horizontal" method="POST" action="{{ route('adress.update', ['id' => $adress->id]) }}">
						{{ csrf_field() }}
								<input type="hidden" name="page"  value="{{ $page }}">
							<!---氏名-->
							<label for="name" class="col-md-4 control-label">氏名</label>
							<div class="col-md-6" style="margin-bottom:5px">
								<input id="name" type="text" class="form-control" name="name" placeholder="氏名" value="{{ old('name', $adress->name) }}" required autofocus>
							</div>
							<!---郵便番号-->
							<label for="postalcode" class="col-md-4 control-label">郵便番号</label>
							<div class="col-md-6" style="margin-bottom:5px">
								<script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>
								<input id="postalcode" type="text" class="form-control" name="postalcode" placeholder="000-0000" value="{{ old('postalcode', $adress->postalcode) }}" onKeyUp="AjaxZip3.zip2addr(this, '', 'prefecture', 'city', 'adress');" required autofocus>
							</div>
							<!---都道府県-->
							<label for="prefecture" class="col-md-4 control-label">都道府県</label>
							<div class="col-md-6" style="margin-bottom:5px">
								<input id="prefecture" type="text" class="form-control" name="prefecture" placeholder="都道府県" value="{{ old('prefecture', $adress->prefecture) }}" required>
							</div>
							<!---市区町村-->
							<label for="city" class="col-md-4 control-label">市区町村</label>
							<div class="col-md-6" style="margin-bottom:5px">
								<input id="city" type="text" class="form-control" name="city" placeholder="市区町村" value="{{ old('city', $adress->city) }}" required>
							</div>
							<!---番地-->
							<label for="adress" class="col-md-4 control-label">番地</label>
							<div class="col-md-6" style="margin-bottom:5px">
								<input id="adress" type="text" class="form-control" name="adress" placeholder="番地・マンション名" value="{{ old('adress', $adress->adress) }}" required>
							</div>
							<!---電話番号-->
							<label for="phonenumber" class="col-md-4 control-label">電話番号</label>
							<div class="col-md-6" style="margin-bottom:5px">
								<input id="phonenumber" type="text" class="form-control" name="phonenumber" placeholder="000-0000-0000" value="{{ old('phonenumber', $adress->phonenumber) }}" required>
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
									変更する
								</button>
								<br>
								<a href="javascript:history.back()">前のページへ戻る</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
