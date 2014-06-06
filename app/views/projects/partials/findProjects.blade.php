@foreach($projects as $project)
	@if($project->priority == 'high')
	<div id="project-{{ $project->id }}" class="project-post office-post high-priority">
	@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date) <= Carbon::now())
	<div id="project-{{ $project->id }}" class="project-post office-post due-now">
	@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->subWeek() <= Carbon::now())
	<div id="project-{{ $project->id }}" class="project-post office-post due-soon">
	@elseif($project->priority == 'low')
	<div id="project-{{ $project->id }}" class="project-post office-post low-priority">
	@else
	<div id="project-{{ $project->id }}" class="project-post office-post">
	@endif

		<div class="post-date"><p>Due:<br>{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }}</p></div>
		<h3>{{ link_to('/project/'.$project->department.'/'. $project->slug, $project->title, array('class' => 'project-link')) }}</h3>
		<div class="post-hover-content">
			<a href="{{ URL::to('/project/'.$project->department.'/'. $project->slug) }}" class="project-link">{{ display_content($project->content, '75') }}</a>
		</div>
		
		<div class="post-activity">
			<small class="ss-user">{{ link_to('/projects/assigned-to/'.User::find($project->assigned_id)->user_path, User::find($project->assigned_id)->first_name) }}</small>
		</div>
		<div class="post-activity">
			<small class="ss-connection">{{ ucwords(str_replace('-',' ',$project->stage)) }}</small>
		</div>
		<div class="post-activity">
			@if($project->priority == 'high')
			<small class="ss-alert">{{ ucwords($project->priority) }}</small>
			@else
			<small class="ss-dashboard">{{ ucwords($project->priority) }}</small>
			@endif
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