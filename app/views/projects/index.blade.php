@extends('layout.main')

@section('page-title')
{{ 'Projects' }}
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">
	<div class="page-menu">
		<ul>
			<li><a href="/projects/all" class="link filter-all">All</a></li>
			<li>
				<select class="filter-status">
					<option value="0">Type Filter</option>
					@if(!empty($project)) {{ get_project_type_select($project->type) }} @else {{ get_project_type_select() }} @endif
				</select>
			</li>
			<li>
				<select class="filter-status">
					<option value="0">Status Filter</option>
					<option value="open">Open</option>
					<option value="closed">Closed</option>
					<option value="archived">Archived</option>
				</select>
			</li>
			<li>
				<select class="filter-priority">
					<option value="0">Priority Filter</option>
					<option value="low">Low</option>
					<option value="normal">Normal</option>
					<option value="high">High</option>
				</select>
			</li>
			<li>
				<select class="filter-user">
					<option value="0">User Filter</option>
					@if(!empty($userAuthor)) {{ get_user_list_select($userAuthor->first_name.' '.$userAuthor->last_name) }} @else {{ get_user_list_select() }} @endif
				</select>
			</li>
			<li>
				<select class="filter-department">
					<option value="0">Department Filter</option>
					<option value="design">Design</option>
					<option value="development">Development</option>
					<option value="sem">S.E.M.</option>
					<option value="print">Print</option>
				</select>
			</li>
			<li><input type="text" class="datepicker filter-date" value="@if(!empty($date)) {{ $date }} @endif" placeholder="Date Filter" data-date-format="mm-yyyy" data-date-viewmode="months"></li>
		</ul>
		<div id="projects-new-project-form" class="create-something-new">
			<span class="projects-button"><button class="add-new">New Project</button></span>
		</div>
	</div>
	
	@foreach($projects as $project)
	<div id="project-{{ $project->id }}" class="project-post office-post">

		<div class="post-date"><p>{{ $project->created_at->format('M j') }}</p></div>
		<h3>{{ link_to('/project/'.$project->department.'/'. $project->slug, $project->title, array('class' => 'project-link')) }}</h3>
		<div class="post-hover-content">
			<a href="{{ URL::to('/project/'.$project->department.'/'. $project->slug) }}" class="project-link">{{ display_content($project->content, '75') }}</a>
		</div>
		
		<div class="project-post-sub office-post-sub">
			
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

</div>
@stop