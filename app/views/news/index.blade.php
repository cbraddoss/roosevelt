@extends('layout.main')

@section('page-title')
{{ 'Company News' }}
@stop


@section('page-content')
<div id="news-page"  class="inner-page">

@include('news.partials.sub-menu')

	@foreach($sticky as $stick)
		@if(strpos($stick->been_read,current_user_path()) !== false) <div id="article-{{ $stick->id }}" class="news-article office-post sticky"> @else <div id="article-{{ $stick->id }}" class="news-article office-post unread sticky"> @endif
			
			<h3>{{ link_to('/news/article/'. $stick->slug, $stick->title, array('class' => 'news-link')) }}</h3>
			<span class="sticky-icon ss-pinboard ss-social"></span>
			
			{{ $stick->getAttachments($stick->id); }}

			<p>{{ display_content($stick->content, '100') }}</p>
			<div class="news-article-sub office-post-sub">
				<small>Posted by {{ link_to('/news/author/'.any_user_path($stick->author_id), User::find($stick->author_id)->first_name) }}</small>
				<small>on {{ link_to('/news/date/'.$stick->created_at->format('Y').'/'.$stick->created_at->format('F'), $stick->created_at->format('F')) }}</small>
				<small>{{ $stick->created_at->format('j, Y') }}</small>
				<small>
					@if(strpos($stick->favorited, current_user_path()) !== false) <span class="ss-heart favorited"> @else <span class="ss-heart"> @endif
					<span favoriteval="{{ $stick->id }}" class="favorite-this none">Favorite This Article</span></span>
				</small>
				<small class="right">
					@if(Auth::user()->id == $stick->author_id || Auth::user()->userrole == 'admin')
					<a class="edit-article edit-link" href="/news/article/{{ $stick->slug }}/edit">Edit Post</a>
					@endif
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