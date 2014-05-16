@foreach($articles as $article)
	@if(strpos($article->been_read,current_user_path()) !== false) <div id="article-{{ $article->id }}" class="news-article office-post"> @else <div id="article-{{ $article->id }}" class="news-article unread"> @endif
		
		{{ $article->getAttachments($article->id) }}
		
		<h3>{{ link_to('/news/article/'. $article->slug, $article->title, array('class' => 'news-link')) }}</h3>
		<p>{{ display_content($article->content, '200') }}</p>
	
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
				{{ link_to('/news/article/'.$article->slug.'/#comments', 'Comments [' . $article->getCommentsCount($article->id) . ']', array('class' => 'comment-link')) }}
			</small>
			{{ Form::open( array('id' => 'favorite-article', 'class' => 'favorite-article', 'url' => '/news/favorites/'.$article->id, 'method' => 'post') ) }}
				{{ Form::hidden('favorite', $article->id) }}
			{{ Form::close() }}
		</div>
	</div>
@endforeach

@if(current_page() != '/' )
@if($articles->links() != '')
<div class="pagination-footer">
	{{ $articles->links() }}
</div>
@endif
@endif