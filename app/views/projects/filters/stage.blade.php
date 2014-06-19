@extends('layout.main')

@section('page-title')
{{ 'Projects at stage: '. ucwords(str_replace('-',' ', $stage)) }}
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
			<span class="page-menu-text">Filtering Stage:</span>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-stage projects-filter">
				<option value="0">Stage Filter</option>
				@if(!empty($stage)) {{ get_project_stage_select($stage) }} @else {{ get_project_stage_select() }} @endif
			</select>
		</li>
	</ul>
	</div>
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">

	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>There are no projects that are at the <i>{{ ucwords($stage) }}</i> stage.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop