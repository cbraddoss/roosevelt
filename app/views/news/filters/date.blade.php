@extends('layout.main')

@section('page-title')
{{ 'Company News - Articles for '. $date  }}
@stop

@section('page-content')
<div id="news-page"  class="inner-page">

@include('news.partials.sub-menu')
	
	<div class="news-filter">
		<ul>
			<li>Filtered for:</li>
			<li><input type="text" class="datepicker filter-date" value="@if(!empty($date)) {{ $date }} @endif" placeholder="Date Filter" data-date-format="mm-yyyy" data-date-viewmode="months"></li>
			<li><a href="/news" class="button filter-all">Reset</a></li>
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