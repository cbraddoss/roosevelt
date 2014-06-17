@extends('layout.main')

@section('page-title')
{{ 'Company News - Unread Articles'  }}
@stop

@section('page-content')
<div id="news-page"  class="inner-page">

<!-- @include('news.partials.sub-menu') -->
	<div class="page-home">
		<a href="/news"><span class="ss-newspaper"></span></a>
	</div>
	<div class="page-return">
		<a href="{{ URL::previous() }}"><span class="ss-reply"></span></a>
	</div>
	<div class="page-menu">
	<ul>
		<li>
			<span class="ss-filter"></span>
			<span class="page-menu-text">Filtering Your Unread:</span>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-type">
				<option value="0">Type Filter</option>
				<option value="unread" selected>Unread</option>
				<option value="mentions">Mentions</option>
				<option value="favorites">Favorites</option>
				<option value="drafts">Drafts</option>
			</select>
		</li>
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