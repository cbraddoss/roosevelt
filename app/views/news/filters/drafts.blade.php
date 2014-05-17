@extends('layout.main')

@section('page-title')
{{ 'Company News - Drafts'  }}
@stop

@section('page-content')
<div id="news-page"  class="inner-page">

@include('news.partials.sub-menu')
		
	@if($articles->isEmpty())
			<div class="news-article office-post">
				<h3>No drafts found.</h3>
				<p></p>
			</div>
	@endif

	@include('news.partials.findArticles')

</div>
@stop