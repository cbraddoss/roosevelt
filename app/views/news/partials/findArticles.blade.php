@foreach($articles as $article)
	@if(strpos($article->been_read,current_user_path()) !== false) <div class="news-article"> @else <div class="news-article unread"><span class="ss-lightbulb"></span> @endif
	
		<h3>{{ convert_title_to_link('/news/article', $article->title, 'news-link') }}</h3>
		<p>{{ $article->content }}</p>
		<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }} on {{ $article->created_at->format('F j, Y') }}</small>
	</div>
@endforeach