@foreach($articles as $article)
	@if(strpos($article->been_read,current_user_path()) !== false) <div id="article-{{ $article->id }}" class="news-article office-post"> @else <div id="article-{{ $article->id }}" class="news-article office-post unread"> @endif
		
		<div class="post-date"><p>{{ $article->created_at->format('M j') }}</p></div>
		<h3>{{ link_to('/news/article/'. $article->slug, $article->title, array('class' => 'news-link')) }}</h3>
		<div class="post-hover-content">
			<a href="{{ URL::to('/news/article/'. $article->slug) }}" class="news-link">{{ display_content($article->content, '75') }}</a>
		</div>
		
		
		<div class="post-assigned">
			<p>
				<img src="{{ gravatar_url(User::find($article->author_id)->email,25) }}" alt="{{ User::find($article->author_id)->first_name }} {{ User::find($article->author_id)->last_name }}">
				{{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }}
			</p>
		</div>
		<div class="post-favorite">
			<p>
				@if(strpos($article->favorited, current_user_path()) !== false) <span id="favorite-{{ $article->id }}" class="ss-heart favorited"> @else <span id="favorite-{{ $article->id }}" class="ss-heart"> @endif
				<span favoriteval="{{ $article->id }}" class="favorite-this none">Favorite Article</span></span>
			
			{{ Form::open( array('id' => 'favorite-article-'.$article->id, 'class' => 'favorite-article', 'url' => '/news/favorites/'.$article->id, 'method' => 'post') ) }}
				{{ Form::hidden('favorite', $article->id) }}
			{{ Form::close() }}
			</p>
		</div>
		@if($article->getCommentsCount($article->id))
		<div class="post-activity">
			<p>{{ link_to('/news/article/'. $article->slug.'#comments', $article->getCommentsCount($article->id), array('class' => 'ss-chat news-link')) }}</p>
		</div>
		@endif
		@if($article->getAttachments($article->id))
		<div class="post-attachment">
			<p class="ss-attach"></p>
		</div>
		@endif
	</div>
@endforeach

@if(current_page() != '/' )
@if($articles->links() != '')
<div class="pagination-footer">
	{{ $articles->links() }}
</div>
@endif
@endif