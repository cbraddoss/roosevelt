@extends('layout.main')

@section('page-title')
{{ 'Company News - Mentions'  }}
@stop

@section('page-content')
<div id="news-page"  class="inner-page">

@include('news.partials.sub-menu')
		
	@if($articles->isEmpty())
			<div class="news-article">
				<h3>No articles mentioning {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} found.</h3>
				<p></p>
			</div>
	@endif

	@include('news.partials.findArticles')

</div>
@stop