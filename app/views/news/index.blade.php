@extends('layout.main')

@section('page-h1')
{{ 'Company News' }}
@stop

@section('page-h2')
{{ 'Company News' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('news.partials.news-menu')
	</ul>
</div>
@stop

@section('page-content')
<div id="news-page"  class="inner-page">
	<h2>@yield('page-h2')</h2>
	@foreach($sticky as $stick)
		@if(strpos($stick->been_read,current_user_path()) !== false) <div id="article-{{ $stick->id }}" class="news-article office-post sticky">
		@else <div id="article-{{ $stick->id }}" class="news-article office-post unread sticky">
		@endif
			<div class="post-favorite post-meta post-tooltip">
					@if(strpos($stick->favorited, current_user_path()) !== false)
					<span id="favorite-{{ $stick->id }}" class="ss-heart favorited tooltip-hover">
					@else
					<span id="favorite-{{ $stick->id }}" class="ss-heart tooltip-hover">
					@endif
					<span favoriteval="{{ $stick->id }}" class="favorite-this tooltip">Favorite Article</span></span>
				
				{{ Form::open( array('id' => 'favorite-article-'.$stick->id, 'class' => 'favorite-article', 'url' => '/news/favorites/'.$stick->id, 'method' => 'post') ) }}
					{{ Form::hidden('favorite', $stick->id) }}
				{{ Form::close() }}
			</div>
			
			@if($stick->getCommentsCount($stick->id))
			<div class="post-activity post-meta post-tooltip">
				<a href="/news/article/{{ $stick->slug }}#comments" class="tooltip-hover ss-chat"><span class="tooltip">{{ $stick->getCommentsCount($stick->id) }}<br />Replies</span></a>
			</div>
			@else
			<div class="post-activity post-meta">
				<span class="ss-chat"></span>
			</div>
			@endif
			@if(!empty($stick->attachment))
			<div class="post-activity post-meta post-tooltip">
				<a href="/news/article/{{ $stick->slug }}" class="tooltip-hover ss-attach"><span class="tooltip">Post<br/>Attachment</span></a>
			</div>
			@else
			<div class="post-activity post-meta">
				<span class="ss-attach"></span>
			</div>
			@endif
	
			<span class="sticky-icon ss-pinboard ss-social"></span>
			<h3>{{ link_to('/news/article/'. $stick->slug, $stick->title, array('class' => 'news-link')) }}</h3>
			<div class="post-date post-detail">
				<span><span class="post-date-text">Posted:</span> {{ $stick->created_at->format('F j') }}</span>
			</div>
			<div class="post-author post-detail post-detail-last">
					<span>
						<img src="{{ gravatar_url(User::find($stick->author_id)->email,15) }}" alt="{{ User::find($stick->author_id)->first_name }} {{ User::find($stick->author_id)->last_name }}">
						By {{ link_to('/news/author/'.any_user_path($stick->author_id), User::find($stick->author_id)->first_name . ' ' . User::find($stick->author_id)->last_name) }}
					</span>
			</div>
		</div>
	@endforeach

	@include('news.partials.findArticles')

</div>
@stop