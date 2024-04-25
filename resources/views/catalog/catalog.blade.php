@extends('layouts.app')

@section('body', 'body-catalog')

@section('content')

<div class="content">
	<div class="center">

		<br><br>

		@include('breadcrumbs.items')

		<br><br>

		{!! @$catalog->admin !!}

		<h1 class="h1">
			{{ @$catalog_page->name }}
		</h1>

		@foreach ($catalog AS $card)
		    <div class="card">
	            <a href="/{{ $page2->url }}/{{ $card->cat_url }}/{{ $card->url }}" class="card-link">
					@if ($card->path <> "")
						<img src="/public/images/catalog/{{ $card->path }}" alt="{{ $card->name }}">
					@else
						<span class="card-img-no">Нет фото</span>
					@endif
	                <div class="card-name">
	                    {{ $card->name }}
	                </div>
	            </a>
		    </div>
		@endforeach


    </div>
</div>

@endsection
