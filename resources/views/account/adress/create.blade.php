@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">新規配送先追加</div>

				<div class="panel-body">
					<form class="form-horizontal" method="POST" action="{{ route('adress.store') }}">
						{{ csrf_field() }}
								<input type="hidden" name="page"  value="{{ $page }}">
							<!---氏名-->
							<label for="product_name" class="col-md-4 control-label">氏名</label>
							<div class="col-md-6" style="margin-bottom:5px">
								<input id="name" type="text" class="form-control" name="name" placeholder="氏名" value="{{ old('name') }}" required autofocus>
							</div>
							<!---郵便番号-->
							<label for="postalcode" class="col-md-4 control-label">郵便番号</label>
							<div class="col-md-6" style="margin-bottom:5px">
								<input id="postalcode" type="text" class="form-control" name="postalcode" placeholder="000-0000" value="{{ old('postalcode') }}" required autofocus>
							</div>
							<!---住所-->
							<label for="prefecture" class="col-md-4 control-label">住所</label>
							<div class="col-md-6" style="margin-bottom:5px">
								<select name="prefecture">
								<option value="北海道">北海道</option>
								<option value="青森県">青森県</option>
								<option value="岩手県">岩手県</option>
								<option value="宮城県">宮城県</option>
								<option value="秋田県">秋田県</option>
								<option value="山形県">山形県</option>
								<option value="福島県">福島県</option>
								<option value="茨城県">茨城県</option>
								<option value="栃木県">栃木県</option>
								<option value="群馬県">群馬県</option>
								<option value="埼玉県">埼玉県</option>
								<option value="千葉県">千葉県</option>
								<option value="東京都" selected>東京都</option>
								<option value="神奈川県">神奈川県</option>
								<option value="新潟県">新潟県</option>
								<option value="富山県">富山県</option>
								<option value="石川県">石川県</option>
								<option value="福井県">福井県</option>
								<option value="山梨県">山梨県</option>
								<option value="長野県">長野県</option>
								<option value="岐阜県">岐阜県</option>
								<option value="静岡県">静岡県</option>
								<option value="愛知県">愛知県</option>
								<option value="三重県">三重県</option>
								<option value="滋賀県">滋賀県</option>
								<option value="京都府">京都府</option>
								<option value="大阪府">大阪府</option>
								<option value="兵庫県">兵庫県</option>
								<option value="奈良県">奈良県</option>
								<option value="和歌山県">和歌山県</option>
								<option value="鳥取県">鳥取県</option>
								<option value="島根県">島根県</option>
								<option value="岡山県">岡山県</option>
								<option value="広島県">広島県</option>
								<option value="山口県">山口県</option>
								<option value="徳島県">徳島県</option>
								<option value="香川県">香川県</option>
								<option value="愛媛県">愛媛県</option>
								<option value="高知県">高知県</option>
								<option value="福岡県">福岡県</option>
								<option value="佐賀県">佐賀県</option>
								<option value="長崎県">長崎県</option>
								<option value="熊本県">熊本県</option>
								<option value="大分県">大分県</option>
								<option value="宮崎県">宮崎県</option>
								<option value="鹿児島県">鹿児島県</option>
								<option value="沖縄県">沖縄県</option>
								</select>
							<!---市区町村-->
								<input id="city" type="text" class="form-control" name="city" placeholder="市区町村" value="{{ old('city') }}" required>
							<!---番地-->
								<input id="adress" type="text" class="form-control" name="adress" placeholder="番地・マンション名" value="{{ old('adress') }}" required>
							</div>
							<!---電話番号-->
							<label for="phonenumber" class="col-md-4 control-label">電話番号</label>
							<div class="col-md-6" style="margin-bottom:5px">
								<input id="phonenumber" type="text" class="form-control" name="phonenumber" placeholder="000-0000-0000" value="{{ old('phonenumber') }}" required>
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
