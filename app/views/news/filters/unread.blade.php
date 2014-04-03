@extends('layout.main')

@section('page-title')
{{ 'Company News - Unread articles for '.  }}
@stop

@section('page-content')
<div id="news-page"  class="inner-page">
	
	<div class="news-filter">
	<ul>
		<li>Filter by:</li>
		<li><a href="/news/unread/{{ current_user_path() }}" class="filter-unread">Unread</button></li>
		<li><a href="/news" class="button filter-all">Reset</a></li>
	</ul>
</div>
	
	@if($articles->isEmpty())
			<div class="news-article">
				<h3>No unread articles found for <i>{{  }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('news.partials.findArticles')

</div>
@stop