@extends('layout.main')

@section('page-title')
{{ 'Company News' }}
@stop


@section('page-content')
<div id="news-page"  class="inner-page">

@include('news.partials.sub-menu')

	@foreach($sticky as $stick)
		@if(strpos($stick->been_read,current_user_path()) !== false) <div id="article-{{ $stick->id }}" class="news-article office-post sticky"> @else <div id="article-{{ $stick->id }}" class="news-article office-post unread sticky"> @endif
			
			<div class="post-date"><p>{{ $stick->created_at->format('M j') }}</p></div>
			<h3>{{ link_to('/news/article/'. $stick->slug, $stick->title, array('class' => 'news-link')) }}</h3>
			<div class="post-hover-content">
				<a href="{{ URL::to('/news/article/'. $stick->slug) }}" class="news-link">{{ display_content($stick->content, '75') }}</a>
			</div>
			<span class="sticky-icon ss-pinboard ss-social"></span>
			
			
			<div class="news-article-sub office-post-sub">
				<small>Posted by {{ link_to('/news/author/'.any_user_path($stick->author_id), User::find($stick->author_id)->first_name) }}</small>
				<small>
					@if(strpos($stick->favorited, current_user_path()) !== false) <span class="ss-heart favorited"> @else <span class="ss-heart"> @endif
					<span favoriteval="{{ $stick->id }}" class="favorite-this none">Favorite This Article</span></span>
				</small>
				{{ Form::open( array('id' => 'favorite-article', 'class' => 'favorite-article', 'url' => '/news/favorites/'.$stick->id, 'method' => 'post') ) }}
					{{ Form::hidden('favorite', $stick->id) }}
				{{ Form::close() }}
			</div>
			@if($stick->getCommentsCount($stick->id))
			<div class="post-activity">
				<p class="ss-chat">{{ link_to('/news/article/'. $stick->slug, $stick->getCommentsCount($stick->id), array('class' => 'news-link')) }}</p>
			</div>
			@endif
			@if($stick->getAttachments($stick->id))
			<div class="post-attachment">
				<p class="ss-attach"></p>
			</div>
			@endif
		</div>
	@endforeach

	@include('news.partials.findArticles')

</div>
@stop