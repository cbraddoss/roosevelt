@foreach($articles as $article)
@if(strpos($article->been_read,current_user_path()) !== false) <div id="article-{{ $article->id }}" class="news-article office-post">
@else <div id="article-{{ $article->id }}" class="news-article office-post unread">
@endif
	<div class="post-favorite post-meta post-tooltip">
			@if(strpos($article->favorited, current_user_path()) !== false)
			<span id="favorite-{{ $article->id }}" class="favorite-this ss-heart favorited tooltip-hover">
			@else
			<span id="favorite-{{ $article->id }}" class="favorite-this ss-heart tooltip-hover">
			@endif
			<span favoriteval="{{ $article->id }}" class="favorite-this-text tooltip">Favorite Article</span></span>
		
		{{ Form::open( array('id' => 'favorite-article-'.$article->id, 'class' => 'favorite-article', 'url' => '/news/favorites/'.$article->id, 'method' => 'post') ) }}
			{{ Form::hidden('favorite', $article->id) }}
		{{ Form::close() }}
	</div>
	
	@if($article->getCommentsCount($article->id))
	<div class="post-activity post-meta post-tooltip">
		<a href="/news/article/{{ $article->slug }}#comments" class="tooltip-hover ss-chat"><span class="tooltip">{{ $article->getCommentsCount($article->id) }}<br />Replies</span></a>
	</div>
	@else
	<div class="post-activity post-meta">
		<span class="ss-chat"></span>
	</div>
	@endif
	@if(!empty($article->attachment))
	<div class="post-activity post-meta post-tooltip">
		<a href="/news/article/{{ $article->slug }}" class="tooltip-hover ss-attach"><span class="tooltip">Post<br/>Attachment</span></a>
	</div>
	@else
	<div class="post-activity post-meta">
		<span class="ss-attach"></span>
	</div>
	@endif
	
	<h3>{{ link_to('/news/article/'. $article->slug, $article->title, array('class' => 'news-link')) }}</h3>
	<div class="post-date post-detail">
		<span><span class="post-date-text">Posted:</span> {{ $article->created_at->format('F j') }}</span>
	</div>
	<div class="post-author post-detail post-detail-last">
			<span>
				<img src="{{ gravatar_url(User::find($article->author_id)->email,15) }}" alt="{{ User::find($article->author_id)->first_name }} {{ User::find($article->author_id)->last_name }}">
				By {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name . ' ' . User::find($article->author_id)->last_name) }}
			</span>
	</div>
	<div class="post-tags post-tooltip">
		<small>
		<div class="tags-added-ajax tags-existing-ajax" formtypeid="{{ $article->id }}" formtype="add-tag-type" formlocation="/news/singleviewupdate/{{ $article->id }}/tag_id">{{ $article->displayTags($article->id, 'article') }}</div>
		</small>
	</div>
</div>
@endforeach

@if(!strpos(current_page(),'tags'))
@if(!strpos(current_page(),'tag'))
@if($articles->links() != '')
<div class="pagination-footer">
	{{ $articles->links() }}
</div>
@endif
@endif
@endif