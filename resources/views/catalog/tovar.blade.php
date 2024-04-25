@extends('layouts.app')

@section('body', 'body-catalog')

@section('content')

<div class="content">

	<div class="center">

		<br><br>

		@include('breadcrumbs.items')

		<br><br>

		{!! @$tovar->admin !!}

		<h1>{{ $tovar->name }}</h1>

    </div>

</div>

@endsection
