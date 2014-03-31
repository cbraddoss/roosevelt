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
		<small>Posted by: {{ User::find($articleView->author_id)->first_name }} on {{ $articleView->created_at }}</small>
	</div>
<p>{{ link_to('/news', 'View all News...') }}</p>
</div>
@stop