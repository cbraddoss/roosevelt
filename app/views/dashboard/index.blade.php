@extends('layout.main')

@section('page-content')
<div id="page-title">
	<h2>Dashboard</h2>
</div>
<div id="quicklinks">
	<p class=""><a href="#" class="ss-check ql-todo-list">To-Do List</a></p>
	<p class=""><a href="#" class="ss-key ql-1password">1Password</a></p>
	<p class=""><a href="#" class="ss-buildings ql-address_book">Address Book</a></p>
	<p class=""><a href="#" class="ss-compose ql-wiki">Wiki</a></p>
	<p class=""><a href="http://my.onsip.com" target="_blank" class="ss-phone ql-voicemail">Voicemail</a></p>
	<p class=""><a href="http://webmail.insideout.com/" target="_blank" class="ss-mail ql-webmail">Webmail</a></p>
	<p class=""><a href="http://login.insideout.com/admin/" target="_blank" class="ss-layout ql-webtools">WebTools</a></p>
	<p class=""><a href="#" class="ss-calendar ql-calendar">Calendar</a></p>
	<p class=""><a href="#" class="ss-globe ql-hosted">Website List</a></p>
	<p class=""><a href="#" class="ss-box ql-dropbox">Dropbox</a></p>
	<span>Request something new...</span>
</div>
<div class="clear"></div>
<div id="page-second-title">
	<h2>Company News</h2>
</div>
<div id="news-feed">
	<ul>
		<li>
			<a href="#" class="news_link">TITLE</a>
			<span class="text-snippet">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book...</span>
			<span class="date-posted">POSTEDDATE</span>
		</li>
		<li><a href="#" class="news_link">TITLE</a>
		<span class="text-snippet">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book...</span>
		<span class="date-posted">POSTEDDATE</span></li>
		<li><a href="#" class="news_link">TITLE</a>
		<span class="text-snippet">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book...</span>
		<span class="date-posted">POSTEDDATE</span></li>
		<li><a href="#" class="news_link">TITLE</a>
		<span class="text-snippet">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book...</span>
		<span class="date-posted">POSTEDDATE</span></li>
		
	</ul>
	<a href="#" class="news_link view-all">View all...</a>
</div>
<div class="clear"></div>
@stop