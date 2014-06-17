@extends('layout.main')

@section('page-title')
{{ 'Company News - Articles for '. $date  }}
@stop

@section('page-content')
<div id="news-page"  class="inner-page">

<!-- @include('news.partials.sub-menu') -->
	<div class="page-home">
		<a href="/news"><span class="ss-newspaper"></span></a>
	</div>
	<div class="page-return">
		<a href="{{ URL::previous() }}"><span class="ss-reply"></span></a>
	</div>
	<div class="page-menu">
	<ul>
		<li>
			<span class="ss-filter"></span>
			<span class="page-menu-text">Filtering Date:</span>
		</li>
		<li>
			<div class="filter-date" data-date="{{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
				<span>@if(!empty($date)) {{ $date }} @elseDate Filter: @endif</span>
				<span class="ss-calendar"></span>
			</div>
		</li>
	</ul>
	</div>

	@if($articles->isEmpty())
			<div class="news-article">
				<h3>No articles found for <i>{{ $date }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('news.partials.findArticles')

</div>
@stop