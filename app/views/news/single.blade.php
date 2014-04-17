@extends('layout.main')

@section('page-title')
{{ $article->title }}
@stop


@section('page-content')
<div id="news-page"  class="inner-page">

@include('news.partials.sub-menu')

	<div class="news-article">
		<p>{{ display_content($article->content) }}</p>
		<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }} on {{ link_to('/news/date/'.$article->created_at->format('Y').'/'.$article->created_at->format('F'), $article->created_at->format('F')) }} {{ $article->created_at->format('j, Y') }}</small>
	</div>
</div>
@stop