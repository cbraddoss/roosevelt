@extends('layout.main')

@section('page-title')
{{ 'Company News - ' . $article->title }}
@stop

@section('page-content')

<div id="news-page"  class="inner-page">

	<div class="news-breadcrumbs">
		<ul>
			<li><a href="/news" class="breadcrumb-link">News</a></li>
			<li>></li>
			<li>{{ convert_title_to_link('/news/article', $article->title, 'news-link breadcrumb-link') }}</li>
		</ul>
	</div>

	<div class="news-article">
		<h3>{{ $article->title }}</h3>
		<p>{{ $article->content }}</p>
		<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }} on {{ $article->created_at->format('F j, Y') }}</small>
	</div>
</div>
@stop