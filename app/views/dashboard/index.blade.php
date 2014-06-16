@extends('layout.main')

@section('page-title')
{{ 'Dashboard' }}
@stop

@section('page-content')
<div id="dashboard-page" class="inner-page">
	<div class="page-menu">
		<span class="menu-start ss-action"></span>
		<ul>
			<li>
				<div id="projects-new-project-form" class="create-something-new">
				<span class="project-button"><button class="add-new">New Project</button></span>
				</div>
			</li>
			<li>
				<div id="billables-new-billable-form" class="create-something-new">
				<span class="billable-button"><button class="add-new">New Billable</button></span>
				</div>
			</li>
			<li>
				<div id="accounts-new-account-form" class="create-something-new">
				<span class="account-button"><button class="add-new">New Account</button></span>
				</div>
			</li>
			<li>
				<div id="help-new-help-form" class="create-something-new">
				<span class="help-button"><button class="add-new">New Help</button></span>
				</div>
			</li>
			<li>
				<div id="news-new-article-form" class="create-something-new">
				<span class="news-button"><button class="add-new">New Post</button></span>
				</div>
			</li>
		</ul>
	</div>
	<div id="quicklinks">
		<p class=""><a href="/to-do/{{ current_user_path() }}" class="ss-check ql-todo-list">To-Do List</a></p>
		<p class=""><a href="#" target="_blank" class="ss-key ql-1password">1Password</a></p>
		<p class=""><a href="http://my.onsip.com" target="_blank" class="ss-phone ql-voicemail">Voicemail</a></p>
		<p class=""><a href="http://webmail.insideout.com/" target="_blank" class="ss-mail ql-webmail">Webmail</a></p>
		<p class=""><a href="https://dropbox.com" target="_blank" class="ss-dropbox ss-social">Dropbox</a></p>
		<p class=""><a href="/calendar" class="ss-calendar ql-calendar">Calendar</a></p>
		<p class=""><a href="/accounts" class="ss-buildings ql-address_book">Address Book</a></p>
		<p class=""><a href="/wiki" class="ss-compose ql-wiki">Wiki</a></p>
		<p class=""><a href="http://login.insideout.com/admin/" target="_blank" class="ss-layout ql-webtools">WebTools</a></p>
		<p class=""><a href="#" class="ss-globe ql-hosted">Website List</a></p>
		<p class=""><a href="/tools" class="ss-signpost ql-tools">Tools</a></p>
		<p class=""><a href="/projects/launches" class="ss-uploadcloud ql-site-launches">Site Launches</a></p>
	</div>
	<div id="page-second-title">
		<h2>Company News</h2>
	</div>
	<div id="news-page">
				
		@include('news.partials.findArticles')
		
		<a href="/news" class="news_link view-all">View all...</a>
	</div>
	<div class="clear"></div>
</div>
@stop