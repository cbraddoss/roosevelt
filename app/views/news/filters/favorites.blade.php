@extends('layout.main')

@section('page-title')
{{ 'Company News - Favorite Articles'  }}
@stop

@section('page-content')
<div id="news-page"  class="inner-page">

@include('news.partials.sub-menu')
		
	@if($articles->isEmpty())
			<div class="news-article office-post">
				<h3>No favorite articles found. Click on a heart <span class="ss-heart"></span> to favortie an article!</h3>
				<p></p>
			</div>
	@endif

	@include('news.partials.findArticles')

</div>
@stop