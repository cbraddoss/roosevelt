@extends('layout.main')

@section('page-title')
{{ 'Company News - Articles by '.$userAuthor->first_name.' '.$userAuthor->last_name }}
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
			<span class="page-menu-text">Filtering Author:</span>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-author news-filter">
				<option value="0">Author Filter</option>
				@if(!empty($userAuthor)) {{ get_user_list_select($userAuthor->first_name.' '.$userAuthor->last_name) }} @else {{ get_user_list_select() }} @endif
			</select>
		</li>
	</ul>
	</div>
@stop

@section('page-content')
<div id="news-page"  class="inner-page">

	@if($articles->isEmpty())
			<div class="news-article">
				<h3>No articles found for <i>{{ $userAuthor->first_name.' '.$userAuthor->last_name }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('news.partials.findArticles')

</div>
@stop