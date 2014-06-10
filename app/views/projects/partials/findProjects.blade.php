@if(!$projects->isEmpty())
<div class="project-title office-post-header">
	<div class="post-date">Due Date</div>
	<div class="post-title">Title</div>
	<div class="post-user">User</div>
	<div class="post-stage">Stage</div>
	<div class="post-meta">Meta</div>
</div>
@endif
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

		<div class="post-date">
		@if(!empty($closed))
			<p>Done:<br>{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->updated_at)->format('F j') }}</p>
		@elseif(!empty($archived))
			<p>Done:<br>{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->updated_at)->format('F j') }}</p>
		@else
			@if(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') == Carbon::now()->format('Y-m-d'))
			<p class="change-project-date" data-date="{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('m-d-Y') }}" data-date-format="mm-dd-yyyy" data-date-viewmode="days">Due:<br>Today<span class="ss-write"></span><span class="ss-calendar"><span class="update-hover-text">Update</span></span></p>
			@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') < Carbon::now()->format('Y-m-d'))
			<p class="change-project-date" data-date="{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('m-d-Y') }}" data-date-format="mm-dd-yyyy" data-date-viewmode="days">Past Due!<br>{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }}<span class="ss-write"></span><span class="ss-calendar"><span class="update-hover-text">Update</span></span></p>
			@else
			<p class="change-project-date" data-date="{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('m-d-Y') }}" data-date-format="mm-dd-yyyy" data-date-viewmode="days">Due:<br>{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }}<span class="ss-write"></span><span class="ss-calendar"><span class="update-hover-text">Update</span></span></p>
			@endif
		@endif
		{{ Form::open( array('id' => 'change-project-date-'.$project->id, 'class' => 'change-project-date-form', 'url' => '/projects/listviewupdate/'.$project->id.'/due_date', 'method' => 'post') ) }}
			{{ Form::hidden('id', $project->id) }}
		{{ Form::close() }}
		</div>
		<h3>{{ link_to('/project/'.$project->department.'/'. $project->slug, $project->title, array('class' => 'project-link')) }}</h3>
		<div class="post-hover-content">
			<a href="{{ URL::to('/project/'.$project->department.'/'. $project->slug) }}" class="project-link">{{ display_content($project->content, '75') }}</a>
		</div>
		
		<div class="post-assigned">
			<p class="change-project-user">
				<img src="{{ gravatar_url(User::find($project->assigned_id)->email,25) }}" alt="{{ User::find($project->assigned_id)->first_name }} {{ User::find($project->assigned_id)->last_name }}">{{ User::find($project->assigned_id)->first_name }}
				<span class="ss-write"></span>
				<select class="change-project-user-list" name="change-project-user-list">{{ get_active_user_list_select(User::find($project->assigned_id)->first_name. ' ' .User::find($project->assigned_id)->last_name) }}</select>
			</p>
			
		{{ Form::open( array('id' => 'change-project-user-'.$project->id, 'class' => 'change-project-user-form', 'url' => '/projects/listviewupdate/'.$project->id.'/assigned_id', 'method' => 'post') ) }}
			{{ Form::hidden('id', $project->id) }}
		{{ Form::close() }}
		</div>
		@if(strlen($project->stage) >= 10)
		<div class="post-stage post-stage-long">
		@else
		<div class="post-stage">
		@endif
			<p class="">{{ ucwords(str_replace('-',' ',$project->stage)) }}</p>
		</div>
		<div class="post-attachment">
			<p class="ss-attach"></p>
		</div>
		<div class="post-activity">
			<p class="ss-chat"></p>
		</div>
		
	</div>
@endforeach

@if(current_page() != '/' || current_page() != '/to-do/brad-doss' )
	@if($projects->links() != '')
	<div class="pagination-footer">
		{{ $projects->links() }}
	</div>
	@endif
@endif