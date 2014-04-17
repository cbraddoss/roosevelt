@section('extra-menu')
<li><a href="/news/" class="button filter-all">All</a></li>
<li><a href="/news/unread/" class="button filter-unread">Unread</a></li>
<li><a href="/news/favorites/" class="button filter-favorites">Favorites</a></li>
<li><a href="/news/mentions/" class="button filter-mentions">Mentions</a></li>
<li><a href="/news/drafts/" class="button filter-drafts">Drafts</a></li>
@stop

<div class="create-something-new-bg"></div>
<div id="news-new-article-form" class="create-something-new">
	@if(strpos(current_page(), 'news/article' ))
	<span class="news-button"><a class="button edit-article" href="/news/article/{{ $article->link }}/edit">Edit Post</a></span>
	@else
	<span class="news-button"><button class="add-new">Add New</button></span>
	@endif
</div>