@extends('layout.main')

@section('page-title')
{{ 'Company News' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li>
			<div id="news-new-article-form" class="create-something-new">
				<span class="news-button"><button class="add-new ss-plus">Add New</button></span>
			</div>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-type news-filter">
				<option value="0">Type Filter</option>
				<option value="unread">Unread</option>
				<option value="mentions">Mentions</option>
				<option value="favorites">Favorites</option>
				<option value="drafts">Drafts</option>
			</select>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-author news-filter">
				<option value="0">Author Filter</option>
				@if(!empty($userAuthor)) {{ get_user_list_select($userAuthor->first_name.' '.$userAuthor->last_name) }} @else {{ get_user_list_select() }} @endif
			</select>
		</li>
		<li>
			<div class="filter-date news-filter" data-date="{{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
				<span>Date Filter:</span>
				<span class="ss-calendar"></span>
			</div>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="news-page"  class="inner-page">


	@foreach($sticky as $stick)
		@if(strpos($stick->been_read,current_user_path()) !== false) <div id="article-{{ $stick->id }}" class="news-article office-post sticky"> @else <div id="article-{{ $stick->id }}" class="news-article office-post unread sticky"> @endif
			
			<div class="post-date"><p>{{ $stick->created_at->format('M j') }}</p></div>
			<h3>{{ link_to('/news/article/'. $stick->slug, $stick->title, array('class' => 'news-link')) }}</h3>
			<div class="post-hover-content">
				<a href="{{ URL::to('/news/article/'. $stick->slug) }}" class="news-link">{{ display_content($stick->content, '75') }}</a>
			</div>
			<span class="sticky-icon ss-pinboard ss-social"></span>
			
			
			<div class="post-assigned">
				<p>
					<img src="{{ gravatar_url(User::find($stick->author_id)->email,25) }}" alt="{{ User::find($stick->author_id)->first_name }} {{ User::find($stick->author_id)->last_name }}">
					{{ link_to('/news/author/'.any_user_path($stick->author_id), User::find($stick->author_id)->first_name) }}
				</p>
			</div>
			<div class="post-favorite">
				<p>
					@if(strpos($stick->favorited, current_user_path()) !== false) <span id="favorite-{{ $stick->id }}" class="ss-heart favorited"> @else <span id="favorite-{{ $stick->id }}" class="ss-heart"> @endif
					<span favoriteval="{{ $stick->id }}" class="favorite-this none">Favorite Article</span></span>
				
				{{ Form::open( array('id' => 'favorite-article-'.$stick->id, 'class' => 'favorite-article', 'url' => '/news/favorites/'.$stick->id, 'method' => 'post') ) }}
					{{ Form::hidden('favorite', $stick->id) }}
				{{ Form::close() }}
				</p>
			</div>
			@if($stick->getCommentsCount($stick->id))
			<div class="post-activity">
				<p class="ss-chat">{{ link_to('/news/article/'. $stick->slug, $stick->getCommentsCount($stick->id), array('class' => 'news-link')) }}</p>
			</div>
			@endif
			@if($stick->getAttachments($stick->id))
			<div class="post-attachment">
				<p class="ss-attach"></p>
			</div>
			@endif
		</div>
	@endforeach

	@include('news.partials.findArticles')

</div>
@stop