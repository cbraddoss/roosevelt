@extends('layout.main')

@section('page-h2')
{{ 'Dashboard' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li><a id="pagelink-to-do-brad-doss" href="/to-do/{{ Auth::user()->user_path }}" class="link">To-Do</a></li>
		<li><a id="pagelink-projects-launches" href="/projects/launches" class="link">Launches</a></li>
		<li><a id="pagelink-1password" href="/assets/vault" class="link">Vault</a></li>
		
		<li class="right">
			<div id="news-new-article-form" class="create-something-new">
				<div class="news-button"><span formtype="add-news" formlocation="/news/create" class="add-button add-new"><span class="ss-plus"></span> News</span></div>
			</div>
		</li>
		<li class="right">
			<div id="help-new-help-form" class="create-something-new">
				<div class="help-button"><span formtype="add-help" formlocation="/help/create" class="add-button add-new"><span class="ss-plus"></span> Help</span></div>
			</div>
		</li>
		<li class="right">
			<div id="accounts-new-account-form" class="create-something-new">
				<div class="account-button"><span formtype="add-account" formlocation="/accounts/create" class="add-button add-new"><span class="ss-plus"></span> Account</span></div>
			</div>
		</li>
		<li class="right">
			<div id="billables-new-billable-form" class="create-something-new">
				<div class="billable-button"><span formtype="add-billable" formlocation="/billables/create" class="add-button add-new"><span class="ss-plus"></span> Billable</span></div>
			</div>
		</li>
		<li class="right">
			<div id="projects-new-project-form" class="create-something-new">
				<div class="project-button"><span formtype="add-project" formlocation="/projects/create" class="add-button add-new"><span class="ss-plus"></span> Project</span></div>
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
		<div class="link-box"><a href="/assets/vault" class="ss-key">Vault</a></div>
		<div class="link-box"><a class="ss-check" href="/assets/status">Status</a></div>
		<div class="link-box"><a href="/tags" class="ss-tag">Tags</a></div>
		<div class="link-box"><a href="https://dropbox.com" target="_blank" class="ss-dropbox ss-social">Dropbox</a></div>
		<div class="link-box"><a href="http://my.onsip.com" target="_blank" class="ss-phone">Voicemail</a></div>
		<div class="link-box"><a href="http://webmail.insideout.com/" target="_blank" class="ss-mail">Webmail</a></div>
		<div class="link-box"><a href="/calendar" class="ss-calendar">Calendar</a></div>
		<div class="link-box"><a href="/accounts" class="ss-buildings">Accounts</a></div>
		<div class="link-box"><a href="http://login.insideout.com/admin/" target="_blank" class="ss-layout">WebTools</a></div>
		<div class="link-box"><a href="/assets/websites" class="ss-globe">Websites</a></div>
	</div>
	<div id="dashboard-lists">
		<div id="first-half" class="dashboard-half">
			<h2><a href="/projects/assigned-to/{{ current_user_path() }}">Your To-Do List:</a><small>@if( $projectsCount >= 5 ) [5 of {{ $projectsCount }}] @endif</small></h2>
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
												
							@if(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') == Carbon::now()->format('Y-m-d'))
								<div class="post-alert post-tooltip post-meta">
									<a class="post-due-bump-date tooltip-hover ss-addcalendar"><span class="tooltip">Bump to Tomorrow</span></a>
									<span class="post-due-text-alert">Due Today!</span>
								</div>
								@if($project->priority == 'high')
								<span class="ss-alert high-priority-alert tooltip-hover"><span class="tooltip">High<br />Priority</span></span>
								@endif
								<h3>{{ link_to('/projects/post/'. $project->slug, $project->title, array('class' => 'project-link')) }}</h3>
								<div class="post-due post-detail">
									<span class="post-due-text">Due Date: </span>
									<span class="post-due-date">{{ Carbon::now()->format('F j') }}</span>
								</div>
							@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') < Carbon::now()->format('Y-m-d'))
								<div class="post-alert post-tooltip post-meta">
									<a class="post-due-bump-date tooltip-hover ss-addcalendar"><span class="tooltip">Bump to Tomorrow</span></a>
									<span class="post-due-text-alert">Past Due!</span>
								</div>
								@if($project->priority == 'high')
								<span class="ss-alert high-priority-alert tooltip-hover"><span class="tooltip">High<br />Priority</span></span>
								@endif
								<h3>{{ link_to('/projects/post/'. $project->slug, $project->title, array('class' => 'project-link')) }}</h3>
								<div class="post-due post-detail">
									<span class="post-due-text">Due Date: </span>
									<span class="post-due-date">{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }}</span>
								</div>
							@else
								@if($project->priority == 'high')
								<span class="ss-alert high-priority-alert tooltip-hover"><span class="tooltip">High<br />Priority</span></span>
								@endif
								<h3>{{ link_to('/projects/post/'. $project->slug, $project->title, array('class' => 'project-link')) }}</h3>
								<div class="post-due post-detail">
									<span class="post-due-text">Due Date: </span>
									<span class="post-due-date">{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }}</span>
								</div>
							@endif
							{{ Form::open( array('id' => 'bump-project-date-'.$project->id, 'class' => 'bump-project-date-form', 'url' => '/projects/listviewupdate/'.$project->id.'/due_date', 'method' => 'post') ) }}
								{{ Form::hidden('id', $project->id) }}
							{{ Form::close() }}
							<div class="post-stage post-detail post-detail-last">
								<span>Stage: {{ $project->stage }}</span>
							</div>
						
					</div>
				@endforeach
				<!-- @ include('billables.partials.findBillables') -->

				@if( $projectsCount > 5 )
					<h4><a href="/projects/assigned-to/{{ current_user_path() }}">View All To-Do List Items...</a></h4>
				@endif

				@if($projects->isEmpty())
					<div class="project-post office-post">
						<div class="nothing-to-show">
							<p>You are not currently assigned any tasks.</p>
							<!-- <p>Consider tackling a <a href="/help">Help</a> post, or adding to the <a href="/wiki">Wiki</a>.</p> -->
						</div>

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
						<div class="post-favorite post-meta post-tooltip">
								@if(strpos($article->favorited, current_user_path()) !== false)
								<span id="favorite-{{ $article->id }}" class="favorite-this ss-heart favorited tooltip-hover">
								@else
								<span id="favorite-{{ $article->id }}" class="favorite-this ss-heart tooltip-hover">
								@endif
								<span favoriteval="{{ $article->id }}" class="favorite-this-text tooltip">Favorite Article</span></span>
							
							{{ Form::open( array('id' => 'favorite-article-'.$article->id, 'class' => 'favorite-article', 'url' => '/news/favorites/'.$article->id, 'method' => 'post') ) }}
								{{ Form::hidden('favorite', $article->id) }}
							{{ Form::close() }}
						</div>
						@if($article->getCommentsCount($article->id))
						<div class="post-activity post-meta post-tooltip">
							<a href="/news/article/{{ $article->slug }}#comments" class="tooltip-hover ss-chat"><span class="tooltip">{{ $article->getCommentsCount($article->id) }}<br />Replies</span></a>
						</div>
						@endif
						
						<h3>{{ link_to('/news/article/'. $article->slug, $article->title, array('class' => 'news-link')) }}</h3>
						<div class="post-date post-detail">
							<span><span class="post-date-text">Posted:</span> {{ $article->created_at->format('F j') }}</span>
						</div>
						<div class="post-author post-detail post-detail-last">
								<span>
									<img src="{{ gravatar_url(User::find($article->author_id)->email,15) }}" alt="{{ User::find($article->author_id)->first_name }} {{ User::find($article->author_id)->last_name }}">
									By {{ link_to('/news/author/'.any_user_path($article->author_id), User::find($article->author_id)->first_name . ' ' . User::find($article->author_id)->last_name) }}
								</span>
						</div>
						
					</div>
				@endforeach
				
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
@stop