@extends('layout.main')

@section('page-title')
{{ $article->title }}
@stop


@section('page-content')
<div id="news-page"  class="inner-page">

@include('news.partials.sub-menu')
	
	<div class="create-something-new-bg"></div>
	<div id="news-post-comment-form" class="create-something-new">
		<span class="news-button"><button class="post-comment">Reply</button></span>
	</div>
	
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
			<small class="right">
			@if(Auth::user()->id == $article->author_id || Auth::user()->userrole == 'admin')
			<a class="edit-article" href="/news/article/{{ $article->slug }}/edit">Edit Post</a>
			@endif
			 | Last edit: {{ $article->updated_at->format('F j, Y h:m:s A') }} by {{ User::find($article->edit_id)->first_name }} {{ User::find($article->edit_id)->last_name }}</small>
			{{ Form::open( array('id' => 'favorite-article', 'class' => 'favorite-article', 'url' => '/news/favorites/'.$article->id, 'method' => 'post') ) }}
				{{ Form::hidden('favorite', $article->id) }}
			{{ Form::close() }}
		</div>
	</div>
	
	@foreach($comments as $comment)
	@if(Auth::user()->user_path == User::find($comment->author_id)->user_path) 
		<div id="comment-{{ $comment->id }}" class="news-article-comment current-user-comment">
		<img src="{{ gravatar_url(User::find($comment->author_id)->email) }}" class="comment-author-image current-user-image" alt="{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}">
	@else <div id="comment-{{ $comment->id }}" class="news-article-comment"><img src="{{ gravatar_url(User::find($comment->author_id)->email) }}" class="comment-author-image" alt="{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}">
	@endif
		<span class="comment-author">{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }} said:</span>
		<span class="comment-details">{{ $comment->created_at->format('F j, Y h:m:s A') }}</span>
		<p class="comment-contents">
			{{ $comment->getCommentAttachments($comment->id) }}
			{{ display_content($comment->content) }}
		</p>
	</div>
	@endforeach
</div>
@stop