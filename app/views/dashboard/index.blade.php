@extends('layout.main')

@section('page-title')
{{ 'Dashboard' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li>
			<div id="projects-new-project-form" class="create-something-new">
			<span class="project-button"><a class="anchor-button add-new"><span class="ss-plus"></span> Project</a></span>
			</div>
		</li>
		<li>
			<div id="billables-new-billable-form" class="create-something-new">
			<span class="billable-button"><a class="anchor-button add-new"><span class="ss-plus"></span> Billable</a></span>
			</div>
		</li>
		<li>
			<div id="accounts-new-account-form" class="create-something-new">
			<span class="account-button"><a class="anchor-button add-new"><span class="ss-plus"></span> Account</a></span>
			</div>
		</li>
		<li>
			<div id="help-new-help-form" class="create-something-new">
			<span class="help-button"><a class="anchor-button add-new"><span class="ss-plus"></span> Help</a></span>
			</div>
		</li>
		<li>
			<div id="news-new-article-form" class="create-something-new">
			<span class="news-button"><a class="anchor-button add-new"><span class="ss-plus"></span> News</a></span>
			</div>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="dashboard-page" class="inner-page">
	<div id="site-launches">
		<h2 class="ss-uploadcloud">Site Launches:</h2>
		<a class="dashboard-launch-count" href="/projects/launches"><span>{{ $launchesCount }} Upcoming</span></a>
			@foreach($launches as $launch)
				<div id="project-{{ $launch->id }}" class="project-post office-dashboard-post">
					<div class="post-launch-date">
						<span>{{ Carbon::createFromFormat('Y-m-d H:i:s', $launch->end_date)->format('F j') }}</span>
					</div>
					{{ link_to('/projects/post/'. $launch->slug, $launch->title, array('class' => 'project-link')) }}
				</div>
			@endforeach

			@if($launches->isEmpty())
				<p class="nothing-to-show">There are currently no scheduled launches.</p>
				<div id="quicklinks">
					<p><a href="/#" class="ss-dislike"></a></p>
				</div>
			@endif
	</div>

	<div id="quicklinks">
		<!-- <h3 class="dashboard-subtitle">Quick Links:</h3> -->
		<p><a href="/to-do/{{ current_user_path() }}" class="ss-check ql-todo-list">To-Do List<span class="user-todo" value="">0</span></a></p>
		<p><a href="#" target="_blank" class="ss-key ql-1password">1Password</a></p>
		<p><a href="http://my.onsip.com" target="_blank" class="ss-phone ql-voicemail">Voicemail</a></p>
		<p><a href="http://webmail.insideout.com/" target="_blank" class="ss-mail ql-webmail">Webmail</a></p>
		<p><a href="https://dropbox.com" target="_blank" class="ss-dropbox ss-social">Dropbox</a></p>
		<p><a href="/calendar" class="ss-calendar ql-calendar">Calendar</a>{{ find_assigned_count('calendar') }}</p>
		<p><a href="/accounts" class="ss-buildings ql-address_book">Address Book</a></p>
		<p><a href="/wiki" class="ss-compose ql-wiki">Wiki</a></p>
		<p><a href="http://login.insideout.com/admin/" target="_blank" class="ss-layout ql-webtools">WebTools</a></p>
		<p><a href="#" class="ss-globe ql-hosted">Website List</a></p>
		<p><a href="/tools" class="ss-flask ql-tools">Tools</a></p>
		<p><a href="/projects/launches" class="ss-uploadcloud ql-site-launches">Site Launches</a></p>
	</div>
	
	<div id="dashboard-lists">
		<div id="first-half" class="dashboard-half">
			<h3><a href="/projects/assigned-to/{{ current_user_path() }}">Your To-Do List:</a> @if($projectsCount != 0)<a class="dashboard-list-count" href="/projects/assigned-to/{{ current_user_path() }}"><span>{{ $projectsCount }}</span></a>@endif</h3>
			<div id="projects-dashboard-page" class="dashboard-list">
						
				@foreach($projects as $project)
					@if($project->priority == 'high')
						@if(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') <= Carbon::now()->format('Y-m-d'))
						<div id="project-{{ $project->id }}" class="project-post office-dashboard-post high-priority due-now">
						@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->subWeek()->format('Y-m-d') <= Carbon::now()->format('Y-m-d'))
						<div id="project-{{ $project->id }}" class="project-post office-dashboard-post high-priority due-soon">
						@else
						<div id="project-{{ $project->id }}" class="project-post office-dashboard-post high-priority">
						@endif
					@elseif($project->priority == 'low')
						@if(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') <= Carbon::now()->format('Y-m-d'))
						<div id="project-{{ $project->id }}" class="project-post office-dashboard-post low-priority due-now">
						@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->subWeek()->format('Y-m-d') <= Carbon::now()->format('Y-m-d'))
						<div id="project-{{ $project->id }}" class="project-post office-dashboard-post low-priority due-soon">
						@else
						<div id="project-{{ $project->id }}" class="project-post office-dashboard-post low-priority">
						@endif
					@else
						@if(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') <= Carbon::now()->format('Y-m-d'))
						<div id="project-{{ $project->id }}" class="project-post office-dashboard-post normal-priority due-now">
						@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->subWeek()->format('Y-m-d') <= Carbon::now()->format('Y-m-d'))
						<div id="project-{{ $project->id }}" class="project-post office-dashboard-post normal-priority due-soon">
						@else
						<div id="project-{{ $project->id }}" class="project-post office-dashboard-post normal-priority">
						@endif
					@endif

						<div class="post-due">
						@if(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') == Carbon::now()->format('Y-m-d'))
							<p><span class="post-due-text">Due Today!</span> {{ Carbon::now()->format('M j') }}</p>
							@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') < Carbon::now()->format('Y-m-d'))
							<p><span class="post-due-text">Due Date</span> {{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('M j') }}<br /><span class="post-due-text">(Past Due!)</span></p>
							@else
							<p><span class="post-due-text">Due Date</span> {{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('M j') }}</p>
						@endif
						</div>
						<h3>{{ link_to('/projects/post/'. $project->slug, $project->title, array('class' => 'project-link')) }}</h3>
													
						<!-- <div class="post-stage-dash">
							<span>Stage: {{ $project->stage }}</span>
						</div>	 -->						
					</div>
				@endforeach
				<!-- @ include('billables.partials.findBillables') -->
				@if($projects->isEmpty())
					<p class="nothing-to-show">You are not currently assigned any tasks.</p>
					<div id="quicklinks" class="quicklinks-again">
						<h2 class="dashboard-subtitle">Get Involved:</h2>
						<p><a href="/projects" class="ss-list ql-projects">Projects</a></p>
						<p><a href="/billable" class="ss-dollarsign ql-billable">Billables</a></p>
						<p><a href="/help" class="ss-help ql-help">Help</a></p>
						<p><a href="/wiki" class="ss-compose ql-wiki">Wiki</a></p>
					</div>
				@endif
			</div>
		</div>
		
		<div id="second-half" class="dashboard-half">
			<h3><a href="/news">Latest Company News:</a> @if($articlesCount != 0)<a class="dashboard-list-count" href="/news"><span>{{ $articlesCount }}</span></a>@endif</h3>
			<div id="news-dashboard-page" class="dashboard-list">
						
				@foreach($articles as $article)
					@if(strpos($article->been_read,current_user_path()) !== false) <div id="article-{{ $article->id }}" class="news-article office-dashboard-post"><div class="post-dated"><span class="post-dated-text">Posted</span> {{ $article->created_at->format('M j') }}</div>
					@else <div id="article-{{ $article->id }}" class="news-article -dashboard-post unread"><div class="post-dated"><span class="post-dated-text">Posted</span> {{ $article->created_at->format('M j') }}<br /><span class="post-dated-text">Unread</span></div>
					@endif
						
						
						<h3>{{ link_to('/news/article/'. $article->slug, $article->title, array('class' => 'news-link')) }}</h3>
						
						<div class="post-favorite">
							<p>
								@if(strpos($article->favorited, current_user_path()) !== false) <span id="favorite-{{ $article->id }}" class="ss-heart favorited">
								@else <span id="favorite-{{ $article->id }}" class="ss-heart">
								@endif
								<span favoriteval="{{ $article->id }}" class="favorite-this none">Favorite Article</span></span>
							
							{{ Form::open( array('id' => 'favorite-article-'.$article->id, 'class' => 'favorite-article', 'url' => '/news/favorites/'.$article->id, 'method' => 'post') ) }}
								{{ Form::hidden('favorite', $article->id) }}
							{{ Form::close() }}
							</p>
						</div>
						<!-- <div class="post-author">
								<img src="{{ gravatar_url(User::find($article->author_id)->email,25) }}" alt="{{ User::find($article->author_id)->first_name }} {{ User::find($article->author_id)->last_name }}">
								{{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }}
						</div>
						@if($article->getCommentsCount($article->id))
						<div class="post-activity">
							<p>{{ link_to('/news/article/'. $article->slug.'#comments', $article->getCommentsCount($article->id), array('class' => 'ss-chat news-link')) }}</p>
						</div>
						@endif -->
					</div>
				@endforeach
				
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
@stop