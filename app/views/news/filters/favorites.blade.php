@extends('layout.main')

@section('page-title')
{{ 'Company News - Favorite Articles'  }}
@stop

@section('header-menu')
	<div class="page-menu">
	<ul>
		<li>
			<div id="news-new-article-form" class="create-something-new">
				<span class="news-button"><button class="add-new ss-plus">Add New</button></span>
			</div>
		</li>
		<li>
			<span class="page-menu-text">Filtering Your Favorites</span>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-type news-filter">
				<option value="0">Type Filter</option>
				<option value="unread">Unread</option>
				<option value="mentions">Mentions</option>
				<option value="favorites" selected>Favorites</option>
				<option value="drafts">Drafts</option>
			</select>
		</li>
	</ul>
	</div>
@stop

@section('page-content')
<div id="news-page"  class="inner-page">

	@if($articles->isEmpty())
			<div class="news-article">
				<h3>No favorite articles found. Click on a heart <span class="ss-heart"></span> to favortie an article!</h3>
				<p></p>
			</div>
	@endif

	@include('news.partials.findArticles')

</div>
@stop