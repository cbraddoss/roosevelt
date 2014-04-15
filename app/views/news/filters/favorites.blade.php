@extends('layout.main')

@section('page-title')
{{ 'Company News - Favorite Articles'  }}
@stop

@section('page-content')
<div id="news-page"  class="inner-page">

@include('news.partials.sub-menu')
		
	@if($articles->isEmpty())
			<div class="news-article">
				<h3>No unread articles found.</h3>
				<p></p>
			</div>
	@endif

	@include('news.partials.findArticles')

</div>
@stop