@extends('layout.main')

@section('page-title')
{{ $articleView->title }}
@stop

@section('page-content')
<div id="page-title">
	<h2>Company News</h2>
</div>

<div id="news-page"  class="inner-page">
	<div class="news-article">
		<h3>{{ $articleView->title }}</h3>
		<p>{{ $articleView->content }}</p>
		<small>Posted by {{ link_to('/news/author/'.any_user_path($articleView->author_id), User::find($articleView->author_id)->first_name) }} on {{ $articleView->created_at->format('F j, Y') }}</small>
	</div>
<p>{{ link_to('/news', 'View all News...') }}</p>
</div>
@stop