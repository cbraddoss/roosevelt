@extends('layout.main')

@section('page-title')
{{ 'Company News from '.$userAuthor->first_name.' '.$userAuthor->last_name }}
@stop

@section('page-content')
<div id="page-title">
	<h2>Company News - Articles by {{ $userAuthor->first_name.' '.$userAuthor->last_name }}</h2>
</div>

<div id="news-page"  class="inner-page">
	
	<div class="news-filter">
		<ul>
			<li>Filtered for:</li>
			<li>
				<select class="filter-author">
					<option value="0">Author Filter</option>
					@if(!empty($userAuthor)) {{ get_user_list_select($userAuthor->first_name.' '.$userAuthor->last_name) }} @else {{ get_user_list_select() }} @endif
				</select>
			</li>
			<li><button class="filter-all">Reset</button></li>
		</ul>
	</div>
	
	@if($articles->isEmpty())
			<div class="news-article">
				<h3>No articles found for <i>{{ $userAuthor->first_name.' '.$userAuthor->last_name }}</i>.</h3>
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