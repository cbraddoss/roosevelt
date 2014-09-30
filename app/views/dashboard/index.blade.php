@extends('layout.main')

@section('page-title')
{{ 'Dashboard' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li>
			<div id="projects-new-project-form" class="create-something-new">
			<span class="project-button"><button class="add-new"><span class="ss-plus"></span> Project</button></span>
			</div>
		</li>
		<li>
			<div id="billables-new-billable-form" class="create-something-new">
			<span class="billable-button"><button class="add-new"><span class="ss-plus"></span> Billable</button></span>
			</div>
		</li>
		<li>
			<div id="accounts-new-account-form" class="create-something-new">
			<span class="account-button"><button class="add-new"><span class="ss-plus"></span> Account</button></span>
			</div>
		</li>
		<li>
			<div id="help-new-help-form" class="create-something-new">
			<span class="help-button"><button class="add-new"><span class="ss-plus"></span> Help</button></span>
			</div>
		</li>
		<li>
			<div id="news-new-article-form" class="create-something-new">
			<span class="news-button"><button class="add-new"><span class="ss-plus"></span> News</button></span>
			</div>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="dashboard-page" class="inner-page">
	
	<div id="dashboard-top-half">
		<div id="quicklinks">
			<h2 class="dashboard-subtitle">Quick Links:</h2>
			<p class=""><a href="/to-do/{{ current_user_path() }}" class="ss-check ql-todo-list">To-Do List<span class="user-todo" value="">0</span></a></p>
			<p class=""><a href="#" target="_blank" class="ss-key ql-1password">1Password</a></p>
			<p class=""><a href="http://my.onsip.com" target="_blank" class="ss-phone ql-voicemail">Voicemail</a></p>
			<p class=""><a href="http://webmail.insideout.com/" target="_blank" class="ss-mail ql-webmail">Webmail</a></p>
			<p class=""><a href="https://dropbox.com" target="_blank" class="ss-dropbox ss-social">Dropbox</a></p>
			<p class=""><a href="/calendar" class="ss-calendar ql-calendar">Calendar</a>{{ find_assigned_count('calendar') }}</p>
			<p class=""><a href="/accounts" class="ss-buildings ql-address_book">Address Book</a></p>
			<p class=""><a href="/wiki" class="ss-compose ql-wiki">Wiki</a></p>
			<p class=""><a href="http://login.insideout.com/admin/" target="_blank" class="ss-layout ql-webtools">WebTools</a></p>
			<p class=""><a href="#" class="ss-globe ql-hosted">Website List</a></p>
			<p class=""><a href="/tools" class="ss-flask ql-tools">Tools</a></p>
			<p class=""><a href="/projects/launches" class="ss-uploadcloud ql-site-launches">Site Launches</a></p>
		</div>
	</div>
	<hr class="global-hrule" />
	<div id="dashboard-bottom-half">
		<div id="first-third" class="dashboard-third">
			<h2>Assigned to You:</h2>
			<div id="projects-dashboard-page" class="dashboard-list">
						
				@foreach($projects as $project)
					@if($project->priority == 'high')
						@if(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') <= Carbon::now()->format('Y-m-d'))
						<div id="project-{{ $project->id }}" class="project-post office-post high-priority due-now">
						@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->subWeek()->format('Y-m-d') <= Carbon::now()->format('Y-m-d'))
						<div id="project-{{ $project->id }}" class="project-post office-post high-priority due-soon">
						@else
						<div id="project-{{ $project->id }}" class="project-post office-post high-priority">
						@endif
					@elseif($project->priority == 'low')
						@if(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') <= Carbon::now()->format('Y-m-d'))
						<div id="project-{{ $project->id }}" class="project-post office-post low-priority due-now">
						@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->subWeek()->format('Y-m-d') <= Carbon::now()->format('Y-m-d'))
						<div id="project-{{ $project->id }}" class="project-post office-post low-priority due-soon">
						@else
						<div id="project-{{ $project->id }}" class="project-post office-post low-priority">
						@endif
					@else
						@if(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') <= Carbon::now()->format('Y-m-d'))
						<div id="project-{{ $project->id }}" class="project-post office-post normal-priority due-now">
						@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->subWeek()->format('Y-m-d') <= Carbon::now()->format('Y-m-d'))
						<div id="project-{{ $project->id }}" class="project-post office-post normal-priority due-soon">
						@else
						<div id="project-{{ $project->id }}" class="project-post office-post normal-priority">
						@endif
					@endif

							<div class="post-due">
							@if(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') == Carbon::now()->format('Y-m-d'))
								<p>Due Today!</p>
								@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') < Carbon::now()->format('Y-m-d'))
								<p>{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }} <span class="post-due-text">(Past Due!)</span></p>
								@else
								<p>{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }} <span class="post-due-text">(due date)</span></p>
							@endif
							</div>
							<h3>{{ link_to('/projects/post/'. $project->slug, $project->title, array('class' => 'project-link')) }}</h3>
														
							<div class="post-stage-dash">
								<span>Stage: {{ $project->stage }}</span>
							</div>							
						</div>
						<hr class="list-hrule" />
					@endforeach
				<!-- @ include('billables.partials.findBillables') -->
				
			</div>
		</div>
		<div id="second-third" class="dashboard-third">
			<h2>Site Launches:</h2>
			<div id="launch-dashboard-page" class="dashboard-list">
						
				@foreach($launches as $launch)
					<div id="project-{{ $launch->id }}" class="project-post office-post">
						<div class="post-launch-date">
							<span>{{ Carbon::createFromFormat('Y-m-d H:i:s', $launch->end_date)->format('F j') }} <span class="post-launch-date-text">(launch date)</span></span>
						</div>
						<h3>{{ link_to('/projects/post/'. $launch->slug, $launch->title, array('class' => 'project-link')) }}</h3>
					</div>
					<hr class="list-hrule" />
				@endforeach

			</div>
		</div>
		<div id="third-third" class="dashboard-third">
			<h2>Latest Company News:</h2>
			<div id="news-dashboard-page" class="dashboard-list">
						
				@foreach($articles as $article)
					@if(strpos($article->been_read,current_user_path()) !== false) <div id="article-{{ $article->id }}" class="news-article office-post">
					@else <div id="article-{{ $article->id }}" class="news-article office-post unread">
					@endif
						
						<div class="post-dated">{{ $article->created_at->format('F j') }}</div>
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
						<div class="post-author">
								<img src="{{ gravatar_url(User::find($article->author_id)->email,25) }}" alt="{{ User::find($article->author_id)->first_name }} {{ User::find($article->author_id)->last_name }}">
								{{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name) }}
						</div>
						@if($article->getCommentsCount($article->id))
						<div class="post-activity">
							<p>{{ link_to('/news/article/'. $article->slug.'#comments', $article->getCommentsCount($article->id), array('class' => 'ss-chat news-link')) }}</p>
						</div>
						@endif
					</div>
					<hr class="list-hrule" />
				@endforeach
				
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
@stop