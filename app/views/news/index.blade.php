@extends('layout.main')

@section('page-title')
{{ 'News' }}
@stop

@section('page-content')
<div id="page-title">
	<h2>Company News</h2>
</div>

<div id="news-page"  class="inner-page">

<div class="news-filter">Filter by: All | Author: Brad | Date: 2014-04-01</div>
@foreach($articles as $article)
	@if(strpos($article->been_read,user_path()) !== false) <div class="news-article"> @else <div class="news-article unread"> @endif
	
		<h3>{{ convert_title_to_link('news', $article->title, 'news-link') }}</h3>
		<p>{{ $article->content }}</p>
		<small>Posted by: {{ User::find($article->author_id)->first_name }} on {{ $article->created_at }}</small> {{ $article->been_read }}
	</div>
@endforeach
</div>
@stop