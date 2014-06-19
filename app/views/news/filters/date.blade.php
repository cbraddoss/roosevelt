@extends('layout.main')

@section('page-title')
{{ 'Company News - Articles for '. $date  }}
@stop

@section('header-menu')
	<div class="page-menu">
	<ul>
		<li>
			<div id="news-new-article-form" class="create-something-new">
				<span class="news-button"><button class="add-new ss-plus">Add New</button></span>
			</div>
		</li>
		<li>
			<span class="page-menu-text">Filtering Date:</span>
		</li>
		<li>
			<div class="filter-date news-filter" data-date="{{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
				<span>@if(!empty($date)) {{ $date }} @elseDate Filter: @endif</span>
				<span class="ss-calendar"></span>
			</div>
		</li>
	</ul>
	</div>
@stop

@section('page-content')
<div id="news-page"  class="inner-page">

	@if($articles->isEmpty())
			<div class="news-article">
				<h3>No articles found for <i>{{ $date }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('news.partials.findArticles')

</div>
@stop