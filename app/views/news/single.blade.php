@extends('layout.main')

@section('page-title')
{{ $article->title }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
@if(Auth::user()->id == $article->author_id || Auth::user()->userrole == 'admin')
		<li>
			<div class="create-something-new">
				<button class="add-new"><a class="edit-article edit-link ss-write" href="/news/article/{{ $article->slug }}/edit">Edit Post</a></button>
			</div>
		</li>
@endif
		<li>
			<div class="page-meta">
				@if(strpos($article->favorited, current_user_path()) !== false) <span id="favorite-{{ $article->id }}" class="ss-heart favorited"> @else <span id="favorite-{{ $article->id }}" class="ss-heart"> @endif
				<span favoriteval="{{ $article->id }}" class="favorite-this none">Favorite This Article</span></span>
				
				{{ Form::open( array('id' => 'favorite-article-'.$article->id, 'class' => 'favorite-article', 'url' => '/news/favorites/'.$article->id, 'method' => 'post') ) }}
					{{ Form::hidden('favorite', $article->id) }}
				{{ Form::close() }}
			</div>
		</li>
@if(strpos($article->mentions, Auth::user()->user_path) !== false)
		<li>
			<div class="page-meta">
				<span>@</span>
			</div>
		</li>
@endif
@if($article->getCommentsCount($article->id))
		<li>
			<div class="page-meta">
				{{ link_to('/news/article/'. $article->slug.'#comments', $article->getCommentsCount($article->id), array('class' => 'ss-chat news-link')) }}
			</div>
		</li>
@endif
@if($article->status == 'sticky')
		<li>
			<div class="page-meta">
				<span class="ss-pinboard ss-social"></span>
			</div>
		</li>
@endif
@if($article->getAttachments($article->id))
		<li>
			<div class="page-meta">
				<span class="ss-attach"></span>
			</div>
		</li>
@endif
	</ul>
</div>
@stop

@section('page-content')
<div id="news-page"  class="single-page inner-page">

	<div id="article-{{ $article->id }}" class="news-article office-post-single" slug="{{ $article->slug }}">
		
		{{ $article->getAttachments($article->id); }}
		<p>{{ display_content($article->content) }}</p>
		<div class="news-article-sub office-post-sub">
			<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name.' '.User::find($article->author_id)->last_name) }}</small>
			<small>on {{ link_to('/news/date/'.$article->created_at->format('Y').'/'.$article->created_at->format('F'), $article->created_at->format('F')) }}</small>
			<small>{{ $article->created_at->format('j, Y') }}</small>
			
			<small class="right">
			Last edit: {{ $article->updated_at->format('F j, Y h:i:s A') }} by {{ link_to('/news/author/'.any_user_path($article->edit_id), User::find($article->edit_id)->first_name.' '.User::find($article->edit_id)->last_name) }}
			</small>
			
		</div>
	</div>
	<div id="news-post-comment-form" class="create-something-new">
		<span class="news-button"><button class="post-comment">Reply</button></span>
	</div>
	<h3 class="comment-on">Comments on <i>{{ $article->title }}</i>:</h3>
	<div id="comments"></div>
	@if($comments->isEmpty())
		<p>No comments yet. Reply to start a conversation on this article!</p>
	@else
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
	@endif
</div>
@stop