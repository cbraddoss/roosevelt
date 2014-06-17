@extends('layout.main')

@section('page-title')
{{ $article->title }}
@stop


@section('page-content')
<div id="news-page"  class="inner-page">

	<!-- @include('news.partials.sub-menu') -->
	
	<div id="article-{{ $article->id }}" class="news-article office-post-single">
		
		{{ $article->getAttachments($article->id); }}
		<p>{{ display_content($article->content) }}</p>
		<div class="news-article-sub office-post-sub">
			<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }}</small>
			<small>on {{ link_to('/news/date/'.$article->created_at->format('Y').'/'.$article->created_at->format('F'), $article->created_at->format('F')) }}</small>
			<small>{{ $article->created_at->format('j, Y') }}</small>
			<small>
				@if(strpos($article->favorited, current_user_path()) !== false) <span class="ss-heart favorited"> @else <span class="ss-heart"> @endif
				<span favoriteval="{{ $article->id }}" class="favorite-this none">Favorite This Article</span></span>
			</small>
			<small class="right">
			@if(Auth::user()->id == $article->author_id || Auth::user()->userrole == 'admin')
			<a class="edit-article edit-link" href="/news/article/{{ $article->slug }}/edit">Edit Post</a>
			@endif
			Last edit: {{ $article->updated_at->format('F j, Y h:i:s A') }} by {{ User::find($article->edit_id)->first_name }} {{ User::find($article->edit_id)->last_name }}</small>
			{{ Form::open( array('id' => 'favorite-article', 'class' => 'favorite-article', 'url' => '/news/favorites/'.$article->id, 'method' => 'post') ) }}
				{{ Form::hidden('favorite', $article->id) }}
			{{ Form::close() }}
		</div>
	</div>
	<h3>Article Comments:</h3>
	<div id="news-post-comment-form" class="create-something-new">
		<span class="news-button"><button class="post-comment">Reply</button></span>
	</div>
	<div id="comments"></div>
	@foreach($comments as $comment)
	@if(Auth::user()->user_path == User::find($comment->author_id)->user_path) 
		<div id="comment-{{ $comment->id }}" class="news-article-comment current-user-comment office-post-comment">
		<img src="{{ gravatar_url(User::find($comment->author_id)->email,40) }}" class="comment-author-image current-user-image" alt="{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}">
	@else <div id="comment-{{ $comment->id }}" class="news-article-comment office-post-comment"><img src="{{ gravatar_url(User::find($comment->author_id)->email,40) }}" class="comment-author-image" alt="{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}">
	@endif
		<div class="comment-contents">
			<div class="comment-details">
				<small>
					<span class="comment-author">{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}</span>
					<span class="comment-time">on 
					@if($comment->created_at->format('Y') == Carbon::now()->format('Y'))
						{{ $comment->created_at->format('F j g:i a') }}
					@else
						{{ $comment->created_at->format('F j, Y g:i a') }}
					@endif
					</span>
					@if(Auth::user()->id == $article->author_id || Auth::user()->userrole == 'admin')
						<span class="comment-edit-button"><button class="edit-link edit-comment">Edit</button></span>
					@endif
				</small>
				
				<div class="comment-options">
					<div id="comment-post-comment-form" class="create-something-new">
						<span class="comment-reply-button"><button class="post-comment">Reply</button></span>
					</div>
				</div>
			</div>
			{{ $comment->getCommentAttachments($comment->id) }}
			<p>{{ display_content($comment->content) }}</p>
		</div>
	</div>
	@foreach($subComments as $subComment)
		@if($subComment->reply_to_id == $comment->id)
			@if(Auth::user()->user_path == User::find($subComment->author_id)->user_path) 
				<div id="comment-{{ $subComment->id }}" class="news-article-comment current-user-comment office-post-comment office-post-sub-comment">
				<img src="{{ gravatar_url(User::find($subComment->author_id)->email,40) }}" class="comment-author-image current-user-image" alt="{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}">
			@else <div id="comment-{{ $subComment->id }}" class="news-article-comment office-post-comment office-post-sub-comment"><img src="{{ gravatar_url(User::find($subComment->author_id)->email,40) }}" class="comment-author-image" alt="{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}">
			@endif
				<div class="comment-contents">
					<div class="comment-details">
						<small>
							<span class="comment-author">{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}</span>
							<span class="comment-time">on 
							@if($comment->created_at->format('Y') == Carbon::now()->format('Y'))
								{{ $subComment->created_at->format('F j g:i a') }}
							@else
								{{ $subComment->created_at->format('F j, Y g:i a') }}
							@endif
							</span>
							@if(Auth::user()->id == $article->author_id || Auth::user()->userrole == 'admin')
								<span class="comment-edit-button"><button class="edit-link edit-comment">Edit</button></span>
							@endif
						</small>
					</div>
					{{ $subComment->getCommentAttachments($subComment->id) }}
					<p>{{ display_content($subComment->content) }}</p>
				</div>
			</div>
		@endif
	@endforeach
	@endforeach
</div>
@stop