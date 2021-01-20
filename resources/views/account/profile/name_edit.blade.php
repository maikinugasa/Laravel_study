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
				<div class="panel-heading">ユーザー名変更</div>

				<div class="panel-body">
					<form class="form-horizontal" method="POST" action="{{ route('name.update') }}">
						{{ csrf_field() }}
						<!---パスワード-->
						<label for="password" class="col-md-4 control-label">パスワード</label>
						<div class="col-md-6" style="margin-bottom:5px">
							<input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required autofocus>
						</div>
						<!---ユーザー名-->
						<label for="name" class="col-md-4 control-label">ユーザー名</label>
						<div class="col-md-6" style="margin-bottom:5px">
							<input id="name" type="text" class="form-control" name="name" placeholder="氏名" value="{{ old('name', $user->name) }}" required>
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
