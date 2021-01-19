@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="panel panel-default">
		<div class="panel-body">
			<p>{!! nl2br($msg) !!}</p>
		</div>
		</div>
	</div>
</div>
@endsection
