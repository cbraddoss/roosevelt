@foreach($articles as $article)
	@if(strpos($article->been_read,current_user_path()) !== false) <div class="news-article"> @else <div class="news-article unread"> @endif
	
		<h3>{{ link_to('/news/article/'. $article->link, $article->title, array('class' => 'news-link')) }}</h3>
		<p>{{ display_content($article->content, '100') }}</p>
		<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }} on {{ link_to('/news/date/'.$article->created_at->format('Y').'/'.$article->created_at->format('F'), $article->created_at->format('F')) }} {{ $article->created_at->format('j, Y') }}</small>
	</div>
@endforeach

@if($articles->links() != '')
<div class="pagination-footer">
	{{ $articles->links() }}
</div>
@endif