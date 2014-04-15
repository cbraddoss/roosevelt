@section('extra-menu')
<li><a href="/news/" class="button filter-all">All</a></li>
<li><a href="/news/unread/" class="button filter-unread">Unread</a></li>
<li><a href="/news/favorites/" class="button filter-favorites">Favorites</a></li>
<li><a href="/news/mentions/" class="button filter-mentions">Mentions</a></li>
<li><a href="/news/scheduled/" class="button filter-scheduled">Scheduled</a></li>
@stop

<div class="create-something-new-bg"></div>
<div id="news-new-article-form" class="create-something-new">
	<span class="news-button"><button class="add-new">Add New</button></span>
</div>