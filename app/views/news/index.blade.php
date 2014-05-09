@extends('layout.main')

@section('page-title')
{{ 'Company News' }}
@stop


@section('page-content')
<div id="news-page"  class="inner-page">

@include('news.partials.sub-menu')

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

	@foreach($sticky as $stick)
		@if(strpos($stick->been_read,current_user_path()) !== false) <div id="article-{{ $stick->id }}" class="news-article sticky"> @else <div id="article-{{ $stick->id }}" class="news-article unread sticky"> @endif
			
			<h3>{{ link_to('/news/article/'. $stick->slug, $stick->title, array('class' => 'news-link')) }}</h3>
			<span class="sticky-icon ss-pinboard ss-social"></span>
			
			{{ $stick->getAttachments($stick->id); }}

			<p>{{ display_content($stick->content, '100') }}</p>
			<div class="news-article-sub">
				<small>Posted by {{ link_to('/news/author/'.any_user_path($stick->author_id), User::find($stick->author_id)->first_name) }}</small>
				<small>on {{ link_to('/news/date/'.$stick->created_at->format('Y').'/'.$stick->created_at->format('F'), $stick->created_at->format('F')) }}</small>
				<small>{{ $stick->created_at->format('j, Y') }}</small>
				<small>
					@if(strpos($stick->favorited, current_user_path()) !== false) <span class="ss-heart favorited"> @else <span class="ss-heart"> @endif
					<span favoriteval="{{ $stick->id }}" class="favorite-this none">Favorite This Article</span></span>
				</small>
				<small class="right">
					{{ link_to('/news/article/'.$stick->slug.'/#comments', 'Comments [' . $stick->getCommentsCount($stick->id) . ']', array('class' => 'comment-link')) }}
				</small>
				{{ Form::open( array('id' => 'favorite-article', 'class' => 'favorite-article', 'url' => '/news/favorites/'.$stick->id, 'method' => 'post') ) }}
					{{ Form::hidden('favorite', $stick->id) }}
				{{ Form::close() }}
			</div>

		</div>
	@endforeach

	@include('news.partials.findArticles')

</div>
@stop