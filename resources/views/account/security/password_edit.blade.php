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
			<div class="panel panel-default">
				<div class="panel-heading">パスワード変更</div>

				<div class="panel-body">
					<form class="form-horizontal" method="POST" action="{{ route('password.update') }}">
						{{ csrf_field() }}
						<label for="pass1" class="col-md-4 control-label">現在のパスワード</label>
						<div class="col-md-6" style="margin-bottom:20px">
							<input id="pass1" type="password" class="form-control" name="current_pwd" value="{{ old('pass1') }}" required autofocus>
						</div>
						<label for="pass2" class="col-md-4 control-label">新しいパスワード</label>
						<div class="col-md-6" style="margin-bottom:5px">
							<input id="pass2" type="password" class="form-control" name="new_pwd" value="{{ old('pass2') }}" required>
						</div>
						<label for="pass3" class="col-md-4 control-label">確認用パスワード</label>
						<div class="col-md-6" style="margin-bottom:5px">
							<input id="pass3" type="password" class="form-control" name="confirm_pwd" value="{{ old('pass3') }}" required>
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
