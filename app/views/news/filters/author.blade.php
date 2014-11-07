@extends('layout.main')

@section('page-h1')
{{ 'Company News' }}
@stop

@section('page-h2')
{{ 'Company News by '.$userAuthor->first_name.' '.$userAuthor->last_name }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('news.partials.news-menu')
	</ul>
</div>
@stop

@section('page-content')
<div id="news-page"  class="inner-page">
	<h2>@yield('page-h2')
	<small class="count-of-total">[{{ count($articles) }} of {{ $articlesCount }}]</small></h2>
	@if($articles->isEmpty())
			<div class="news-article">
				<h3>No articles found for <i>{{ $userAuthor->first_name.' '.$userAuthor->last_name }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('news.partials.findArticles')

</div>
@stop