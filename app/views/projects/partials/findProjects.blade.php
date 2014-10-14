@foreach($projects as $project)
@if(!empty($closed))
	<div id="project-{{ $project->id }}" class="project-post office-post">
@elseif(!empty($archived))
	<div id="project-{{ $project->id }}" class="project-post office-post">
@else
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
@endif

		@if(!empty($closed))
		<div class="post-date">
			<p>Done:<br />{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->updated_at)->format('F j') }}</p>
		</div>
		@elseif(!empty($archived))
		<div class="post-date">
			<p>Done:<br />{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->updated_at)->format('F j') }}</p>
		</div>
		@else
			@if(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') == Carbon::now()->format('Y-m-d'))
		<div class="post-date">
			<div class="change-project-date tooltip-hover" data-date="{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('m-d-Y') }}" data-date-format="mm-dd-yyyy" data-date-viewmode="days">
				<span class="tooltip">Change<br />Due Date</span>
				<span class="project-change-date ss-calendar"></span>
				Due Date: <br /><span class="post-due-date">{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }}</span>
				</div>
			<div class="post-alert">
				<span class="post-due-text-alert post-tooltip">
					<a class="post-due-bump-date tooltip-hover ss-addcalendar"><span class="tooltip">Bump to Tomorrow</span> Due Today!</a>
				</span>
							{{ Form::open( array('id' => 'bump-project-date-'.$project->id, 'class' => 'bump-project-date-form', 'url' => '/projects/listviewupdate/'.$project->id.'/due_date', 'method' => 'post') ) }}
								{{ Form::hidden('id', $project->id) }}
							{{ Form::close() }}
			</div>
		</div>
			@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') < Carbon::now()->format('Y-m-d'))
		<div class="post-date">
			<div class="change-project-date tooltip-hover" data-date="{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('m-d-Y') }}" data-date-format="mm-dd-yyyy" data-date-viewmode="days">
				Due Date: <br /><span class="post-due-date">{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }}</span>
				<span class="project-change-date ss-calendar"></span>
				<span class="tooltip">Change<br />Due Date</span>
			</div>
			<div class="post-alert">
				<span class="post-due-text-alert post-tooltip">
					<a class="post-due-bump-date tooltip-hover ss-addcalendar"><span class="tooltip">Bump to Tomorrow</span> Past Due!</a>
				</span>
							{{ Form::open( array('id' => 'bump-project-date-'.$project->id, 'class' => 'bump-project-date-form', 'url' => '/projects/listviewupdate/'.$project->id.'/due_date', 'method' => 'post') ) }}
								{{ Form::hidden('id', $project->id) }}
							{{ Form::close() }}
			</div>
		</div>
			@else
		<div class="post-date">
			<div class="change-project-date tooltip-hover" data-date="{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('m-d-Y') }}" data-date-format="mm-dd-yyyy" data-date-viewmode="days">
				<span class="tooltip">Change<br />Due Date</span>
				Due Date: <br /><span class="post-due-date">{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }}</span>
				<span class="project-change-date ss-calendar"></span>
			</div>
		</div>
			@endif
		@endif
		{{ Form::open( array('id' => 'change-project-date-'.$project->id, 'class' => 'change-project-date-form', 'url' => '/projects/listviewupdate/'.$project->id.'/due_date', 'method' => 'post') ) }}
			{{ Form::hidden('id', $project->id) }}
		{{ Form::close() }}

		<div class="post-assigned">
			<p class="change-project-user">
				<span class="tooltip-hover"><span class="tooltip">Change<br />Author</span>
				<img src="{{ gravatar_url(User::find($project->assigned_id)->email,25) }}" alt="{{ User::find($project->assigned_id)->first_name }} {{ User::find($project->assigned_id)->last_name }}">
				</span>
				<div class="select-dropdown">
					<span class="ss-dropdown"></span>
					<span class="ss-directup"></span>
					<select class="change-project-user-list" name="change-project-user-list">{{ get_active_user_list_select(User::find($project->assigned_id)->first_name. ' ' .User::find($project->assigned_id)->last_name) }}</select>
				</div>
			</p>
			
		{{ Form::open( array('id' => 'change-project-user-'.$project->id, 'class' => 'change-project-user-form', 'url' => '/projects/listviewupdate/'.$project->id.'/assigned_id', 'method' => 'post') ) }}
			{{ Form::hidden('id', $project->id) }}
		{{ Form::close() }}
		</div>
		<div class="post-stage">
			<p class="change-project-stage">
				<span class="post-stage-text tooltip-hover"><span class="tooltip">Change<br />Stage</span>
				Stage:</span>
				<div class="select-dropdown">
					<span class="ss-dropdown"></span>
					<span class="ss-directup"></span>
					<select class="change-project-stage-list" name="change-project-stage-list">{{ $project->getProjectStages($project->stage, $project->id) }}</select>
				</div>
			</p>
		{{ Form::open( array('id' => 'change-project-stage-'.$project->id, 'class' => 'change-project-stage-form', 'url' => '/projects/listviewupdate/'.$project->id.'/stage', 'method' => 'post') ) }}
			{{ Form::hidden('id', $project->id) }}
		{{ Form::close() }}
		</div>
		@if($project->getCommentsCount($project->id))
		<div class="post-activity">
			<a href="/projects/post/{{ $project->slug . '#comments' }}" class="ss-chat projects-link post-icon tooltip-hover"><span class="tooltip">{{ $project->getCommentsCount($project->id) }}<br />Comments</span></a>
		</div>
		@else
		<div class="post-activity">
			<span class="ss-chat projects-link post-icon tooltip-hover"><span class="tooltip">{{ $project->getCommentsCount($project->id) }}<br />Comments</span></span>
		</div>		
		@endif
		@if($project->getAttachments($project->id))
		<div class="post-attachment">
			<a href="/projects/post/{{ $project->slug }}" class="ss-attach post-icon tooltip-hover"><span class="tooltip">Has<br />Attachment</span></a>
		</div>
		@else
		<div class="post-attachment">
			<span class="ss-attach post-icon tooltip-hover"><span class="tooltip">No<br />Attachment</span></span>
		</div>		
		@endif
		@if(find_subscribed($project->id,Auth::user()->user_path))
		<div class="post-subscribed">
			<span id="subscribe-{{ $project->id }}" subscribeval="{{ $project->id }}" class="ss-send post-icon tooltip-hover subscribe-to subscribed-to"><span class="tooltip">Subscribed<br />to Project</span></span>
			{{ Form::open( array('id' => 'subscribe-to-project-'.$project->id, 'class' => 'subscribe-to-project-form', 'url' => '/projects/listviewupdate/'.$project->id.'/subscribed', 'method' => 'post') ) }}
				{{ Form::hidden('id', $project->id) }}
				{{ Form::hidden('subscribed', $project->subscribed) }}
			{{ Form::close() }}
		</div>
		@else
		<div class="post-subscribed">
			<span id="subscribe-{{ $project->id }}" subscribeval="{{ $project->id }}" class="ss-send post-icon tooltip-hover subscribe-to"><span class="tooltip">Subscribe<br />to Project</span></span>
			{{ Form::open( array('id' => 'subscribe-to-project-'.$project->id, 'class' => 'subscribe-to-project-form', 'url' => '/projects/listviewupdate/'.$project->id.'/subscribed', 'method' => 'post') ) }}
				{{ Form::hidden('id', $project->id) }}
				{{ Form::hidden('subscribed', $project->subscribed) }}
			{{ Form::close() }}
		</div>
		@endif

		@if($project->priority == 'high')
		<span class="ss-alert high-priority-alert tooltip-hover"><span class="tooltip">High<br />Priority</span></span>
		@endif

		<div class="post-end-date">
			@if($project->period == 'recurring')
			<span>Start Date: {{ Carbon::createFromFormat('Y-m-d H:i:s', $project->start_date)->format('M j') }} - End Date: {{ Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date)->format('M j') }}</span>
			@else
			<span>Launching: {{ Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date)->format('F j') }}</span>
			@endif
		</div>

		<h3>{{ link_to('/projects/post/'. $project->slug, $project->title, array('class' => 'project-link')) }}</h3>
		<div class="post-content">
			<a href="{{ URL::to('/projects/post/'. $project->slug) }}" class="project-link">{{ display_content($project->content, '75') }}</a>
		</div>
		
		

		
		
	</div>
@endforeach

@if(current_page() != '/')
 <!-- || current_page() != '/to-do/brad-doss' -->
	@if($projects->links() != '')
	<div class="pagination-footer">
		{{ $projects->links() }}
	</div>
	@endif
@endif