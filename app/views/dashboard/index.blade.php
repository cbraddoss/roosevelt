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
	
	<div id="quicklinks">
		<h2>Quick Links:</h2>
		<div class="link-box"><a href="/to-do/{{ current_user_path() }}" class="ss-check">To-Do List<span class="user-todo" value="">0</span></a></div>
		<div class="link-box"><a href="/projects/launches" class="ss-uploadcloud">Launches<span class="user-todo" value="">{{ $launchesCount }}</span></a></div>
		<div class="link-box"><a href="/1Password" target="_blank" class="ss-key">1Password</a></div>
		<div class="link-box"><a href="http://my.onsip.com" target="_blank" class="ss-phone">Voicemail</a></div>
		<div class="link-box"><a href="http://webmail.insideout.com/" target="_blank" class="ss-mail">Webmail</a></div>
		<div class="link-box"><a href="https://dropbox.com" target="_blank" class="ss-dropbox ss-social">Dropbox</a></div>
		<div class="link-box"><a href="/calendar" class="ss-calendar">Calendar</a></div>
		<div class="link-box"><a href="/accounts" class="ss-buildings">Accounts</a></div>
		<div class="link-box"><a href="/wiki" class="ss-compose">Wiki</a></div>
		<div class="link-box"><a href="http://login.insideout.com/admin/" target="_blank" class="ss-layout">WebTools</a></div>
		<div class="link-box"><a href="/websites" class="ss-globe">Websites</a></div>
		<div class="link-box"><a href="/tools" class="ss-flask">Tools</a></div>
	</div>
	<!-- <div id="site-launches">
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
	</div> -->
	<div id="dashboard-lists">
		<div id="first-half" class="dashboard-half">
			<h2><a href="/projects/assigned-to/{{ current_user_path() }}">Your To-Do List:</a></h2>
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
						<div id="project-{{ $project->id }}" class="project-post office-post due-now">
						@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->subWeek()->format('Y-m-d') <= Carbon::now()->format('Y-m-d'))
						<div id="project-{{ $project->id }}" class="project-post office-post due-soon">
						@else
						<div id="project-{{ $project->id }}" class="project-post office-post">
						@endif
					@endif
						<h3>{{ link_to('/projects/post/'. $project->slug, $project->title, array('class' => 'project-link')) }}</h3>
						
						<div class="post-meta">
							<div class="post-due">
							@if(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') == Carbon::now()->format('Y-m-d'))
								<p><span class="post-due-text">Due Date: </span>{{ Carbon::now()->format('F j') }} <span class="post-due-text-right">Due Today!</span></p>
								@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') < Carbon::now()->format('Y-m-d'))
								<p><span class="post-due-text">Due Date: </span>{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }} <span class="post-due-text-right">Past Due!</span></p>
								@else
								<p><span class="post-due-text">Due Date: </span>{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }}</p>
							@endif
							<div class="post-stage">
								<span>Stage: {{ $project->stage }}</span>
							</div>
							</div>
						</div>
						
					</div>
				@endforeach
				<!-- @ include('billables.partials.findBillables') -->

				@if( $projectsCount > 5 )
					<h4><a href="/projects/assigned-to/{{ current_user_path() }}">View All To-Do List Items...</a></h4>
				@endif

				@if($projects->isEmpty())
					<div class="project-post office-post">
						<p class="nothing-to-show">You are not currently assigned any tasks.<br /><br />Consider tackling a <a href="/help">Help</a> post, or adding to the <a href="/wiki">Wiki</a>.</p>

					</div>
					<div id="quicklinks" class="quicklinks-again">
						<h2 class="dashboard-subtitle">Get Involved:</h2>
						<div class="link-box"><a href="/projects" class="ss-list ql-projects">Projects</a></div>
						<div class="link-box"><a href="/billable" class="ss-dollarsign ql-billable">Billables</a></div>
						<div class="link-box"><a href="/help" class="ss-help ql-help">Help</a></div>
						<div class="link-box"><a href="/news" class="ss-newspaper ql-news">News</a></div>
					</div>
				@endif
			</div>
		</div>
		
		<div id="second-half" class="dashboard-half">
			<h2><a href="/news">Latest Company News:</a></h2>
			<div id="news-dashboard-page" class="dashboard-list">
						
				@foreach($articles as $article)
					@if(strpos($article->been_read,current_user_path()) !== false) <div id="article-{{ $article->id }}" class="news-article office-post">
					@else <div id="article-{{ $article->id }}" class="news-article office-post unread">
					@endif
						<h3>{{ link_to('/news/article/'. $article->slug, $article->title, array('class' => 'news-link')) }}</h3>
						
						<div class="post-meta">
							<div class="post-date">
							<span><span class="post-date-text">Posted:</span> {{ $article->created_at->format('F j') }}</span>
							</div>
							<div class="post-favorite">
								<span>
									@if(strpos($article->favorited, current_user_path()) !== false) <span id="favorite-{{ $article->id }}" class="ss-heart favorited">
									@else <span id="favorite-{{ $article->id }}" class="ss-heart">
									@endif
									<span favoriteval="{{ $article->id }}" class="favorite-this none">Favorite Article</span></span>
								
								{{ Form::open( array('id' => 'favorite-article-'.$article->id, 'class' => 'favorite-article', 'url' => '/news/favorites/'.$article->id, 'method' => 'post') ) }}
									{{ Form::hidden('favorite', $article->id) }}
								{{ Form::close() }}
								</span>
							</div>
							
							@if($article->getCommentsCount($article->id))
							<div class="post-activity">
								<span>{{ link_to('/news/article/'. $article->slug.'#comments', $article->getCommentsCount($article->id), array('class' => 'ss-chat news-link')) }}</span>
							</div>
							@endif
							<div class="post-author">
									<span>
										<img src="{{ gravatar_url(User::find($article->author_id)->email,15) }}" alt="{{ User::find($article->author_id)->first_name }} {{ User::find($article->author_id)->last_name }}">
										By {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name . ' ' . User::find($article->author_id)->last_name) }}
									</span>
							</div>
							
							
						</div>
					</div>
				@endforeach
				
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
@stop