@extends('layout.main')

@section('page-title')
{{ 'Company News - Favorite Articles'  }}
@stop

@include('news.partials.sub-menu')

@section('page-content')
<div id="news-page"  class="inner-page">
		
	@if($articles->isEmpty())
			<div class="news-article">
				<h3>No unread articles found.</h3>
				<p></p>
			</div>
	@endif

	@include('news.partials.findArticles')

</div>
@stop