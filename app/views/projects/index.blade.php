@extends('layout.main')

@section('page-title')
{{ 'Projects' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li>
			<div id="projects-new-project-form" class="create-something-new">
				<span class="projects-button"><button class="add-new ss-plus">Add New</button></span>
			</div>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-status projects-filter">
				<option value="0">Status Filter</option>
				@if(!empty($open)) <option value="open" selected>Open</option> @else <option value="open">Open</option> @endif
				@if(!empty($closed)) <option value="closed" selected>Closed</option> @else <option value="closed">Closed</option> @endif
				@if(!empty($archived)) <option value="archived" selected>Archived</option> @else <option value="archived">Archived</option> @endif
			</select>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-type projects-filter">
				<option value="0">Type Filter</option>
				@if(!empty($type)) {{ get_project_type_select($type) }} @else {{ get_project_type_select() }} @endif
			</select>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-priority projects-filter">
				<option value="0">Priority Filter</option>
				@if(!empty($low)) <option value="low" selected>Low</option> @else <option value="low">Low</option> @endif
				@if(!empty($normal)) <option value="normal" selected>Normal</option> @else <option value="normal">Normal</option> @endif
				@if(!empty($high)) <option value="high" selected>High</option> @else <option value="high">High</option> @endif
			</select>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-user projects-filter">
				<option value="0">User Filter</option>
				@if(!empty($user)) {{ get_user_list_select($user->first_name.' '.$user->last_name) }} @else {{ get_user_list_select() }} @endif
			</select>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-stage projects-filter">
				<option value="0">Stage Filter</option>
				@if(!empty($stage)) {{ get_project_stage_select($stage) }} @else {{ get_project_stage_select() }} @endif
			</select>
		</li>
		<li class="select-date">
			<div class="filter-date projects-filter" data-date="{{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
				<span>Date Filter:</span>
				<span class="ss-calendar"></span>
			</div>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">
	
	@include('projects.partials.sub-menu')

	@include('projects.partials.findProjects')

</div>
@stop