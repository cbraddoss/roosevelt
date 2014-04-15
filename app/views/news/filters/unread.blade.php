@extends('layout.main')

@section('page-title')
{{ 'Company News - Unread Articles'  }}
@stop

@section('extra-menu')
	<li><a href="/news/unread/" class="button filter-unread">Unread</a></li>
	<li><a href="/news/favorites/" class="button filter-unread">Favorites</a></li>
	<li><a href="/news/scheduled/" class="button filter-unread">Scheduled</a></li>
	<li><a href="/news/mentioned/" class="button filter-unread">Mentioned</a></li>
@stop

@section('page-content')
<div id="news-page"  class="inner-page">
	
	<div class="news-filter">
		<ul>
			<li>Filtered for:</li>
			<li>Unread Articles</li>
			<li><a href="/news" class="button filter-all">Reset</a></li>
		</ul>
	</div>
	
	@if($articles->isEmpty())
			<div class="news-article">
				<h3>No unread articles found.</h3>
				<p></p>
			</div>
	@endif

	@include('news.partials.findArticles')

</div>
@stop