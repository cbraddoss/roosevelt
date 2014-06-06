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
			<p>Due:<br>Today</p>
			@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('Y-m-d') < Carbon::now()->format('Y-m-d'))
			<p>Past Due!<br>{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }}</p>
			@else
			<p>Due:<br>{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }}</p>
			@endif
		@endif
		</div>
		<h3>{{ link_to('/project/'.$project->department.'/'. $project->slug, $project->title, array('class' => 'project-link')) }}</h3>
		<div class="post-hover-content">
			<a href="{{ URL::to('/project/'.$project->department.'/'. $project->slug) }}" class="project-link">{{ display_content($project->content, '75') }}</a>
		</div>
		
		<div class="post-assigned">
			<p class=""><img src="{{ gravatar_url(User::find($project->assigned_id)->email,25) }}" alt="{{ User::find($project->assigned_id)->first_name }} {{ User::find($project->assigned_id)->last_name }}">{{ link_to('/projects/assigned-to/'.User::find($project->assigned_id)->user_path, User::find($project->assigned_id)->first_name) }}</p>
		</div>
		@if(strlen($project->stage) >= 10)
		<div class="post-stage post-stage-long">
		@else
		<div class="post-stage">
		@endif
			<p class="">{{ ucwords(str_replace('-',' ',$project->stage)) }}</p>
		</div>
		
		<div class="post-activity">
			<p class="ss-chat"></p>
		</div>
		
	</div>
@endforeach

@if(current_page() != '/' )
	@if($projects->links() != '')
	<div class="pagination-footer">
		{{ $projects->links() }}
	</div>
	@endif
@endif