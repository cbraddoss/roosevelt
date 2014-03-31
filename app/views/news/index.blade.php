@extends('layout.main')

@section('page-title')
{{ 'News' }}
@stop

@section('page-content')
<div id="page-title">
	<h2>Company News</h2>
</div>

<div id="news-page"  class="inner-page">
@foreach($articles as $article)
	<div class="news-article">
		<h3>{{ $article->title }}</h3>
		<p>{{ $article->content }}</p>
		<small>Posted by: {{ User::find($article->author_id)->first()->first_name }} on {{ $article->created_at }}</small>
	</div>
@endforeach
</div>
@stop