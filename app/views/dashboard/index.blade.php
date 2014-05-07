@extends('layout.main')

@section('page-title')
{{ 'Dashboard' }}
@stop

@section('page-content')
<div id="quicklinks">
	<p class=""><a href="/todo/{{ current_user_path() }}" class="ss-check ql-todo-list">To-Do List</a></p>
	<p class=""><a href="#" target="_blank" class="ss-key ql-1password">1Password</a></p>
	<p class=""><a href="/accounts" class="ss-buildings ql-address_book">Address Book</a></p>
	<p class=""><a href="/wiki" class="ss-compose ql-wiki">Wiki</a></p>
	<p class=""><a href="http://my.onsip.com" target="_blank" class="ss-phone ql-voicemail">Voicemail</a></p>
	<p class=""><a href="http://webmail.insideout.com/" target="_blank" class="ss-mail ql-webmail">Webmail</a></p>
	<p class=""><a href="http://login.insideout.com/admin/" target="_blank" class="ss-layout ql-webtools">WebTools</a></p>
	<p class=""><a href="/calendar" class="ss-calendar ql-calendar">Calendar</a></p>
	<p class=""><a href="#" class="ss-globe ql-hosted">Website List</a></p>
	<p class=""><a href="https://dropbox.com" target="_blank" class="ss-dropbox ss-social">Dropbox</a></p>
	<span><a></a></span>
</div>
<div class="clear"></div>
<div id="page-second-title">
	<h2>Company News</h2>
</div>
<div id="news-page">
			
	@foreach($articles as $article)
		@if(strpos($article->been_read,current_user_path()) !== false) <div id="article-{{ $article->id }}" class="news-article"> @else <div id="article-{{ $article->id }}" class="news-article unread"> @endif
			
			{{ $article->getAttachments($article->id); }}
			
			<h3>{{ link_to('/news/article/'. $article->slug, $article->title, array('class' => 'news-link')) }}</h3>
			<p>{{ display_content($article->content, '200') }}</p>
		
			<div class="news-article-sub">
				<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }}</small>
				<small>on {{ link_to('/news/date/'.$article->created_at->format('Y').'/'.$article->created_at->format('F'), $article->created_at->format('F')) }}</small>
				<small>{{ $article->created_at->format('j, Y') }}</small>
				<small>
					@if(strpos($article->favorited, current_user_path()) !== false) <span class="ss-heart favorited"> @else <span class="ss-heart"> @endif
					<span favoriteval="{{ $article->id }}" class="favorite-this none">Favorite This Article</span></span>
				</small>
				<small class="right">
					{{ link_to('/news/article/'.$article->slug.'/#comments', 'Comments [?]', array('class' => 'comment-link')) }}
				</small>
				{{ Form::open( array('id' => 'favorite-article', 'class' => 'favorite-article', 'url' => '/news/favorites/'.$article->id, 'method' => 'post') ) }}
					{{ Form::hidden('favorite', $article->id) }}
				{{ Form::close() }}
			</div>
		</div>
	@endforeach
	
	<a href="/news" class="news_link view-all">View all...</a>
</div>
<div class="clear"></div>
@stop