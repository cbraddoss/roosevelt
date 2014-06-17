@extends('layout.main')

@section('page-title')
{{ 'Company News - Articles by '.$userAuthor->first_name.' '.$userAuthor->last_name }}
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
			<span class="page-menu-text">Filtering Author:</span>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-author">
				<option value="0">Author Filter</option>
				@if(!empty($userAuthor)) {{ get_user_list_select($userAuthor->first_name.' '.$userAuthor->last_name) }} @else {{ get_user_list_select() }} @endif
			</select>
		</li>
	</ul>
	</div>

	@if($articles->isEmpty())
			<div class="news-article">
				<h3>No articles found for <i>{{ $userAuthor->first_name.' '.$userAuthor->last_name }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('news.partials.findArticles')

</div>
@stop