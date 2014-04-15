@extends('layout.main')

@section('page-title')
{{ 'Company News' }}
@stop

@section('page-content')
<div class="create-something-new-bg"></div>
<div id="news-new-article-form" class="create-something-new">
	<span class="news-button"><button class="add-new">Add New</button></span>
</div>

<div id="news-page"  class="inner-page">

	<div class="news-filter">
		<ul>
			<li>Quick Filter <small>(choose one)</small>:</li>
			<li>
				<select class="filter-author">
					<option value="0">Author Filter</option>
					@if(!empty($userAuthor)) {{ get_user_list_select($userAuthor->first_name.' '.$userAuthor->last_name) }} @else {{ get_user_list_select() }} @endif
				</select>
			</li>
			<li><input type="text" class="datepicker filter-date" value="@if(!empty($date)) {{ $date }} @endif" placeholder="Date Filter" data-date-format="mm-yyyy" data-date-viewmode="months"></li>
			<li><a href="/news/unread/" class="button filter-unread">Unread</a></li>
			<li>Favorites</li>
		</ul>
	</div>

	@include('news.partials.findArticles')

</div>
@stop