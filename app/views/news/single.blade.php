@extends('layout.main')

@section('page-h1')
{{ 'Company News' }}
@stop

@section('page-h2')
{{ $article->title }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
@if($article->status == 'sticky')
		<li>
			<div class="page-meta post-attachment post-tooltip">
				<a class="tooltip-hover ss-pinboard ss-social"><span class="tooltip">Sticky Post</span></a>
			</div>
		</li>
@endif
		<li>
			<div class="page-meta post-favorite post-tooltip">
				@if(strpos($article->favorited, current_user_path()) !== false)
				<span id="favorite-{{ $article->id }}" class="favorite-this ss-heart favorited tooltip-hover">
				@else
				<span id="favorite-{{ $article->id }}" class="favorite-this ss-heart tooltip-hover">
				@endif
				<span favoriteval="{{ $article->id }}" class="favorite-this-text tooltip">Favorite</span></span>
				
				{{ Form::open( array('id' => 'favorite-article-'.$article->id, 'class' => 'favorite-article', 'url' => '/news/favorites/'.$article->id, 'method' => 'post') ) }}
					{{ Form::hidden('favorite', $article->id) }}
				{{ Form::close() }}
			</div>
		</li>
@if(strpos($article->mentions, Auth::user()->user_path) !== false)
		<li>
			<div class="page-meta post-tooltip">
				<a class="tooltip-hover"><span class="tooltip">Mentioned!</span>@</a>
			</div>
		</li>
@else
		<li>
			<div class="page-meta post-activity post-tooltip">
				<span class="tooltip-hover"><span class="tooltip">No Mentions</span>@</span>
			</div>
		</li>
@endif
@if($article->getCommentsCount($article->id))
		<li>
			<div class="page-meta post-activity post-tooltip">
			<a href="/news/article/{{ $article->slug . '#comments' }}" class="ss-chat tooltip-hover news-link"><span class="tooltip">{{ $article->getCommentsCount($article->id) }} Comments</span></a>
			</div>
		</li>
@else
		<li>
			<div class="page-meta post-tooltip">
				<span class="tooltip-hover ss-chat"><span class="tooltip">No Comments</span></span>
			</div>
		</li>
@endif
@if($article->getAttachments($article->id))
		<li>
			<div class="page-meta post-tooltip">
				<a class="tooltip-hover ss-attach"><span class="tooltip">Attachment</span></a>
			</div>
		</li>
@else
		<li>
			<div class="page-meta post-tooltip">
				<span class="tooltip-hover ss-attach"><span class="tooltip">No Attachments</span></span>
			</div>
		</li>
@endif
	</ul>
</div>
@stop

@section('page-content')
<div id="news-page"  class="single-page inner-page">
	<h2>@yield('page-h2')</h2>

	<div id="article-{{ $article->id }}" class="news-article office-post-single" slug="{{ $article->slug }}">
		
		{{ $article->getAttachments($article->id); }}
		<p>{{ display_content($article->content) }}</p>
		<div class="news-article-sub office-post-sub">
			<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name.' '.User::find($article->author_id)->last_name) }}</small>
			<small>on {{ link_to('/news/date/'.$article->created_at->format('Y').'/'.$article->created_at->format('F'), $article->created_at->format('F')) }}</small>
			<small>{{ $article->created_at->format('j, Y') }}</small>
			@if(Auth::user()->id == $article->author_id || Auth::user()->userrole == 'admin')
			<small><a class="edit-article edit-link link" href="/news/article/{{ $article->slug }}/edit">Edit Post</a></small>
			@endif
			<small class="right">
			Last edit: {{ $article->updated_at->format('F j, Y h:i:s A') }} by {{ link_to('/news/author/'.any_user_path($article->edit_id), User::find($article->edit_id)->first_name.' '.User::find($article->edit_id)->last_name) }}
			</small>
			
		</div>
	</div>
	
	<div id="news-post-comment-form" class="create-something-new">
		<div class="news-button">
			<span formtype="post-reply" formlocation="/news/article/{{ $article->slug }}/comment" class="post-comment add-button">
			<span class="ss-reply"></span> Reply</span>
		</div>
	</div>
	<h3 class="comment-on">Comments on <i>{{ $article->title }}</i>:</h3>
	
	<div id="comments"></div>
	@if($comments->isEmpty())
		<p>No comments yet. Reply to start a conversation on this article!</p>
	@else
		@foreach($comments as $comment)
			@if(Auth::user()->user_path == User::find($comment->author_id)->user_path) 
				<div id="comment-{{ $comment->id }}" class="news-article-comment current-user-comment office-post-comment">
				<img src="{{ gravatar_url(User::find($comment->author_id)->email,30) }}" class="comment-author-image current-user-image" alt="{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}">
				<span class="comment-author" author="{{ User::find($comment->author_id)->first_name }}">{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}:</span>
			@else
				<div id="comment-{{ $comment->id }}" class="news-article-comment office-post-comment">
				<img src="{{ gravatar_url(User::find($comment->author_id)->email,30) }}" class="comment-author-image" alt="{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}">
				<span class="comment-author" author="{{ User::find($comment->author_id)->first_name }}">{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}:</span>
			@endif
				<div class="comment-contents">
					{{ $comment->getCommentAttachments($comment->id) }}
					<p class="comment-text">{{ display_content($comment->content) }}</p>
					<div class="comment-details">
						<div class="comment-meta">
							<div class="comment-options">
								<div id="comment-post-comment-form" class="create-something-new">
									<div class="comment-reply-button">
										<span commentid="{{ $comment->id }}" formtype="comment-reply" formlocation="/news/article/{{ $article->slug }}/comment" class="post-comment add-button">
										<span class="ss-reply"></span> Reply</span>
									</div>
								</div>
							</div>

							<span class="comment-posted">Posted: </span>
							<span class="comment-time">
							@if($comment->created_at->format('Y') == Carbon::now()->format('Y'))
								{{ $comment->created_at->format('F j g:i a') }}
							@else
								{{ $comment->created_at->format('F j, Y g:i a') }}
							@endif
							</span> | 
							@if($comment->created_at != $comment->updated_at)
							<small>
							{{ User::find($comment->edit_id)->first_name }} edited: 
							@if($comment->updated_at->format('Y') == Carbon::now()->format('Y'))
								{{ $comment->updated_at->format('F j g:i a') }}
							@else
								{{ $comment->updated_at->format('F j, Y g:i a') }}
							@endif
							</small> | 
							@endif
							<span class="comment-permalink"><a href="/news/article/{{ $article->slug }}#comment-{{ $comment->id }}">Permalink</a></span>
							@if(Auth::user()->id == $comment->author_id || Auth::user()->userrole == 'admin')
								<span class="comment-edit-button">
									 | <a commentid="{{ $comment->id }}" formtype="comment-edit" formlocation="/news/article/comment/{{ $comment->id }}/edit" class="edit-link edit-comment">Edit</a>
								</span>
							@endif
							
						</div>
					</div>
				</div>
			</div>
			@foreach($subComments as $subComment)
				@if($subComment->reply_to_id == $comment->id)
					@if(Auth::user()->user_path == User::find($subComment->author_id)->user_path) 
						<div id="comment-{{ $subComment->id }}" class="news-article-comment current-user-comment office-post-comment office-post-sub-comment">
						<img src="{{ gravatar_url(User::find($subComment->author_id)->email,30) }}" class="comment-author-image current-user-image" alt="{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}">
						<span class="comment-author">{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}:</span>
					@else
						<div id="comment-{{ $subComment->id }}" class="news-article-comment office-post-comment office-post-sub-comment">
						<img src="{{ gravatar_url(User::find($subComment->author_id)->email,30) }}" class="comment-author-image" alt="{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}">
						<span class="comment-author">{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}:</span>
					@endif
						<div class="comment-contents">
							{{ $subComment->getCommentAttachments($subComment->id) }}
							<p class="comment-text">{{ display_content($subComment->content) }}</p>
							<div class="comment-details">
								<div class="comment-meta">
									<span class="comment-posted">Posted: </span>
									<span class="comment-time">
									@if($subComment->created_at->format('Y') == Carbon::now()->format('Y'))
										{{ $subComment->created_at->format('F j g:i a') }}
									@else
										{{ $subComment->created_at->format('F j, Y g:i a') }}
									@endif
									</span> | 
									@if($subComment->created_at != $subComment->updated_at)
									<small>
									{{ User::find($subComment->edit_id)->first_name }} edited: 
									@if($subComment->updated_at->format('Y') == Carbon::now()->format('Y'))
										{{ $subComment->updated_at->format('F j g:i a') }}
									@else
										{{ $subComment->updated_at->format('F j, Y g:i a') }}
									@endif
									</small> | 
									@endif
									<span class="comment-permalink"><a href="/news/article/{{ $article->slug }}#comment-{{ $subComment->id }}">Permalink</a></span>
									@if(Auth::user()->id == $subComment->author_id || Auth::user()->userrole == 'admin')
										<span class="comment-edit-button">
											 | <a commentid="{{ $subComment->id }}" formtype="comment-edit" formlocation="/news/article/comment/{{ $subComment->id }}/edit" class="edit-link edit-comment">Edit</a>
										</span>
									@endif
								</div>
							</div>
						</div>
					</div>
				@endif
			@endforeach
		@endforeach
	@endif
</div>
@stop