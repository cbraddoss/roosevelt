@extends('layout.main')

@section('page-title')
{{ $article->title }}
@stop

@section('page-content')

<div id="news-page"  class="inner-page">

	<div class="news-article">
		<p>{{ $article->content }}</p>
		<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }} on {{ $article->created_at->format('F j, Y') }}</small>
	</div>
</div>
@stop