@if (count(@$breadcrumbs) > 0)
	<div itemscope itemtype="https://schema.org/BreadcrumbList" class="breadcrumbs">
		<span class="breadcrumbs-name-wrap" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<a class="breadcrumbs-name" itemprop="item" href="/"><span itemprop="name">Главная</span></a>
			<meta itemprop="position" content="1">
		</span>

		@foreach(@$breadcrumbs AS $item)
			<span class="breadcrumbs-name-wrap" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				@if (!empty(@$item[1]))
					<a class="breadcrumbs-name" itemprop="item" href="{{ $item[1] }}">
						<span itemprop="name">
							{{ $item[0] }}
						</span>
					</a>
				@else
					<span class="breadcrumbs-name" itemprop="name">
						{{ $item[0] }}
					</span>
				@endif
				<meta itemprop="position" content="{{ $loop->iteration }}">
			</span>
		@endforeach
	</div>
@endif
