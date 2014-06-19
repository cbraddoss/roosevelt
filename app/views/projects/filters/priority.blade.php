@extends('layout.main')

@section('page-title')
{{ 'Projects - '. ucwords($priority) .' priority' }}
@stop

@section('header-menu')
	<div class="page-menu">
	<ul>
		<li>
			<div id="projects-new-project-form" class="create-something-new">
				<span class="projects-button"><button class="add-new ss-plus">Add New</button></span>
			</div>
		</li>
		<li>
			<span class="page-menu-text">Filtering Priority:</span>
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
	</ul>
	</div>
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">

	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>There are no projects with a priority of <i>{{ $priority }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop