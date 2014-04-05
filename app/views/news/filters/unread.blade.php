@extends('layout.main')

@section('page-title')
{{ 'Company News - Unread Articles'  }}
@stop

@section('page-content')
<div id="news-page"  class="inner-page">
	
	<div class="news-filter">
		<ul>
			<li>View:</li>
			<li><a href="/news" class="button filter-all">All News</a></li>
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