@foreach($articles as $article)
	@if(strpos($article->been_read,current_user_path()) !== false) <div id="article-{{ $article->id }}" class="news-article"> @else <div id="article-{{ $article->id }}" class="news-article unread"> @endif
		@if(is_array(unserialize($article->attachment)))
			@foreach(unserialize($article->attachment) as $attach)
				<span class="right article-all-attachment"><a href="{{ '/uploads/'.$attach }}"><img src="{{ '/uploads/'.$attach }}" class="article-attachment"></a></span>
			@endforeach
		@elseif (!empty($article->attachment))
			<span class="right article-all-attachment"><a href="{{ '/uploads/'.$article->attachment }}"><img src="{{ '/uploads/'.$article->attachment }}" class="article-attachment"></a></span>
		@endif

		<h3>{{ link_to('/news/article/'. $article->slug, $article->title, array('class' => 'news-link')) }}</h3>
		<p>{{ display_content($article->content, '100') }}</p>
		<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }}</small>
		<small>on {{ link_to('/news/date/'.$article->created_at->format('Y').'/'.$article->created_at->format('F'), $article->created_at->format('F')) }}</small>
		<small>{{ $article->created_at->format('j, Y') }}</small>
		<small>
			@if(strpos($article->favorited, current_user_path()) !== false) <span class="ss-heart favorited"> @else <span class="ss-heart"> @endif
			<span favoriteval="{{ $article->id }}" class="favorite-this none">Favorite This Article</span>
		</small>
		<small class="right">
			{{ link_to('/news/article/'.$article->slug.'/#comments', 'Comments [?]', array('class' => 'comment-link')) }}
		</small>
		{{ Form::open( array('id' => 'favorite-article', 'class' => 'favorite-article', 'url' => '/news/favorites/'.$article->id, 'method' => 'post') ) }}
			{{ Form::hidden('favorite', $article->id) }}
		{{ Form::close() }}

	</div>
@endforeach

@if($articles->links() != '')
<div class="pagination-footer">
	{{ $articles->links() }}
</div>
@endif