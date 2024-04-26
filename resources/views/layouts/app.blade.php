<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8" />
	<title>@yield("title", $title)</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="@yield("description", $description)" />
	<meta name="keywords" content="@yield("keywords", $keywords)" />
	
	<link rel="stylesheet" type="text/css" href="/public/css/slick.css?v=6" />
	
	<link rel="stylesheet" type="text/css" href="/public/css/style.css?{{rand()}}" />
	<link rel="stylesheet" type="text/css" href="/public/css/media.css?{{rand()}}" />
	<link rel="stylesheet" type="text/css" href="/public/css/style2.css?{{rand()}}" />
	<link rel="stylesheet" type="text/css" href="/public/css/sandwiches.css?{{rand()}}" />
	<script src="
https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
"></script>
    <link href="
https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css
" rel="stylesheet">
	<script src="../../js/accordion.js?v=2"></script>
	<script src="/public/js/block_height.js?v=2"></script>
	<script src="/public/js/sandwichmenu.js?v=2"></script>
	<link rel="shortcut icon" href="/public/favicon.ico?v=3" />
</head>
<body class="@yield("body")">

	@include('layouts.scripts')

	<div id="black-wrap">
		<div id="black"></div>
		<div id="mod" class="anime-mod">
			<div id="close"></div>
			<div id="modbox"></div>
		</div>
	</div>
	<div class="message">
		{!! @$message !!}
	</div>
	<div class="wrap">

		@include('layouts.header')

			@yield("content")

		@include('layouts.footer')

	</div>

	<script src="/public/js/jquery.js?v=11"></script>
	<script src="/public/js/slick.js?v=2"></script>
	<script src="/public/js/main.js?{{rand()}}"></script>
</body>
</html>
