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
<div id="news-feed">
	<ul>
		@foreach($articles as $article)
		@if(strpos($article->been_read,current_user_path()) !== false) <li> @else <li class="unread"> @endif
			<h3>{{ link_to('news/article/'.$article->link, $article->title) }}</h3>
			<p>{{ display_content($article->content, '100') }}</p>
			<small>Posted by {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }} on {{ link_to('/news/date/'.$article->created_at->format('Y').'/'.$article->created_at->format('F'), $article->created_at->format('F')) }} {{ $article->created_at->format('j, Y') }}</small>
		</li>
		@endforeach
	</ul>
	<a href="/news" class="news_link view-all">View all...</a>
</div>
<div class="clear"></div>
@stop