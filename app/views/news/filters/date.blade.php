@extends('layout.main')

@section('page-title')
{{ 'Company News - Articles for '. $date  }}
@stop

@section('page-content')
<div id="page-title">
	<h2>Company News - Articles for {{ $date }} </h2>
</div>

<div id="news-page"  class="inner-page">
	
	<div class="news-filter">
		<ul>
			<li>Filtered for:</li>
			<li><input type="text" class="datepicker filter-date" value="@if(!empty($date)) {{ $date }} @endif" placeholder="Date Filter" data-date-format="mm-yyyy" data-date-viewmode="months"></li>
			<li><button class="filter-all">Reset</button></li>
		</ul>
	</div>
	
	@if($articles->isEmpty())
			<div class="news-article">
				<h3>No articles found for <i>{{ $date }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@foreach($articles as $article)
		
		@if(strpos($article->been_read,current_user_path()) !== false) <div class="news-article"> @else <div class="news-article unread"> @endif
		
			<h3>{{ convert_title_to_link('news', $article->title, 'news-link') }}</h3>
			<p>{{ $article->content }}</p>
			<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }} on {{ $article->created_at->format('F j, Y') }}</small>
		</div>
		
	@endforeach

</div>
@stop