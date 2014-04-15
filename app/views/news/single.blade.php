@extends('layout.main')

@section('page-title')
{{ $article->title }}
@stop

@include('news.partials.sub-menu')

@section('page-content')

<div id="news-page"  class="inner-page">

	<div class="news-article">
		<p>{{ $article->content }}</p>
		<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }} on {{ link_to('/news/date/'.$article->created_at->format('Y').'/'.$article->created_at->format('F'), $article->created_at->format('F j, Y')) }}</small>
	</div>
</div>
@stop