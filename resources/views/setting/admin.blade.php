<div class='edits-wrap'>
  <div class='edits {{ $class }}'>
    <a class='edit' target='_blank' href='{{ $href }}'>Редактировать</a>
    @if ($seo == 1)
      {!! $editseo !!}
    @endif
  </div>
</div>
