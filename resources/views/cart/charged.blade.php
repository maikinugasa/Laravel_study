@extends('layouts.app_cart')
@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<p style="text-align:center; font-weight:bold; padding:10px;">
ご購入ありがとうございます！<br>
決済が完了しました。
</p>
</div>
<p style="text-align:center;">
<a href="{{ action('ItemController@index') }}">トップページへ戻る</a>
</p>
</div>
</div>
</div>
@endsection
