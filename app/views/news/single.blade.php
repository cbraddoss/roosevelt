@extends('layout.main')

@section('page-title')
{{ $article->title }}
@stop

@section('extra-menu')
	<li><a href="/news/unread/" class="button filter-unread">Unread</a></li>
	<li><a href="/news/favorites/" class="button filter-unread">Favorites</a></li>
	<li><a href="/news/scheduled/" class="button filter-unread">Scheduled</a></li>
	<li><a href="/news/mentioned/" class="button filter-unread">Mentioned</a></li>
@stop

@section('page-content')

<div id="news-page"  class="inner-page">

	<div class="news-article">
		<p>{{ $article->content }}</p>
		<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }} on {{ link_to('/news/date/'.$article->created_at->format('Y').'/'.$article->created_at->format('F'), $article->created_at->format('F j, Y')) }}</small>
	</div>
</div>
@stop