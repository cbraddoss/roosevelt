@extends('layout.main')

@section('page-title')
{{ 'Company News' }}
@stop

@section('extra-menu')
	<li><a href="/news/unread/" class="button filter-unread">Unread</a></li>
	<li><a href="/news/favorites/" class="button filter-unread">Favorites</a></li>
	<li><a href="/news/scheduled/" class="button filter-unread">Scheduled</a></li>
	<li><a href="/news/mentioned/" class="button filter-unread">Mentioned</a></li>
@stop

@section('page-content')
<div id="news-page"  class="inner-page">

<div class="create-something-new-bg"></div>
<div id="news-new-article-form" class="create-something-new">
	<span class="news-button"><button class="add-new">Add New</button></span>
</div>

	<div class="news-filter">
		<ul>
			<li>View by:</li>
			<li>
				<select class="filter-author">
					<option value="0">Author Filter</option>
					@if(!empty($userAuthor)) {{ get_user_list_select($userAuthor->first_name.' '.$userAuthor->last_name) }} @else {{ get_user_list_select() }} @endif
				</select>
			</li>
			<li><input type="text" class="datepicker filter-date" value="@if(!empty($date)) {{ $date }} @endif" placeholder="Date Filter" data-date-format="mm-yyyy" data-date-viewmode="months"></li>
		</ul>
	</div>

	@include('news.partials.findArticles')

</div>
@stop