@extends('layout.main')

@section('page-content')
<div id="page-title">
	<h2>Dashboard</h2>
</div>
<div id="quicklinks">
	<p class=""><a href="/todo/{{ lcfirst(Auth::user()->first_name) }}-{{ lcfirst(Auth::user()->last_name) }}" class="ss-check ql-todo-list">To-Do List</a></p>
	<p class=""><a href="#" target="_blank" class="ss-key ql-1password">1Password</a></p>
	<p class=""><a href="/accounts" class="ss-buildings ql-address_book">Address Book</a></p>
	<p class=""><a href="/wiki" class="ss-compose ql-wiki">Wiki</a></p>
	<p class=""><a href="http://my.onsip.com" target="_blank" class="ss-phone ql-voicemail">Voicemail</a></p>
	<p class=""><a href="http://webmail.insideout.com/" target="_blank" class="ss-mail ql-webmail">Webmail</a></p>
	<p class=""><a href="http://login.insideout.com/admin/" target="_blank" class="ss-layout ql-webtools">WebTools</a></p>
	<p class=""><a href="/calendar" class="ss-calendar ql-calendar">Calendar</a></p>
	<p class=""><a href="#" class="ss-globe ql-hosted">Website List</a></p>
	<p class=""><a href="https://dropbox.com" target="_blank" class="ss-box ql-dropbox">Dropbox</a></p>
	<span><a href="/tools">View Tools page for more...</a></span>
</div>
<div class="clear"></div>
<div id="page-second-title">
	<h2>Company News</h2>
</div>
<div id="news-feed">
	<ul>
		@foreach($articles as $article)
		@if(strpos($article->been_read,user_path()) !== false) <li> @else <li class="unread"> @endif
			<h3>{{ convert_title_to_link('news', $article->title) }}</h3>
			<p>{{ $article->content }}</p>
			<small>Posted by: {{ User::find($article->author_id)->first_name }} on {{ $article->created_at }}</small>
		</li>
		@endforeach
	</ul>
	<a href="/news" class="news_link view-all">View all...</a>
</div>
<div class="clear"></div>
@stop