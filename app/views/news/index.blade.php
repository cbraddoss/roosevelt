@extends('layout.main')

@section('page-title')
{{ 'Company News' }}
@stop

@section('page-content')
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
			<li><button class="filter-unread">Unread</button></li>
			<li>Favorites</li>
		</ul>
	</div>

	@foreach($articles as $article)
		@if(strpos($article->been_read,current_user_path()) !== false) <div class="news-article"> @else <div class="news-article unread"><span class="ss-lightbulb"></span> @endif
		
			<h3>{{ convert_title_to_link('news', $article->title, 'news-link') }}</h3>
			<p>{{ $article->content }}</p>
			<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }} on {{ $article->created_at->format('F j, Y') }}</small>
		</div>
	@endforeach

</div>
@stop