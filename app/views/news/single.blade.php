@extends('layout.main')

@section('page-title')
{{ $article->title }}
@stop


@section('page-content')
<div id="news-page"  class="inner-page">

@include('news.partials.sub-menu')

	<div id="article-{{ $article->id }}" class="news-article">
		
		{{ $article->getAttachments($article->id); }}

		<p>{{ display_content($article->content) }}</p>
		<div class="news-article-sub">
			<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }}</small>
			<small>on {{ link_to('/news/date/'.$article->created_at->format('Y').'/'.$article->created_at->format('F'), $article->created_at->format('F')) }}</small>
			<small>{{ $article->created_at->format('j, Y') }}</small>
			<small>
				@if(strpos($article->favorited, current_user_path()) !== false) <span class="ss-heart favorited"> @else <span class="ss-heart"> @endif
				<span favoriteval="{{ $article->id }}" class="favorite-this none">Favorite This Article</span></span>
			</small>
			<small class="right">Last edit: {{ $article->updated_at->format('F j, Y h:m:s A') }} by {{ User::find($article->edit_id)->first_name }} {{ User::find($article->edit_id)->last_name }}</small>
			{{ Form::open( array('id' => 'favorite-article', 'class' => 'favorite-article', 'url' => '/news/favorites/'.$article->id, 'method' => 'post') ) }}
				{{ Form::hidden('favorite', $article->id) }}
			{{ Form::close() }}
		</div>
	</div>
	<div id="comments" class="post-comment"><span class="button">Reply</span></div>
</div>
@stop