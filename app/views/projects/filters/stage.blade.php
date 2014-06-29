@extends('layout.main')

@section('page-title')
{{ 'Projects at stage: '. convert_path_to_stage($stage) }}
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
				{{ $projectStages }}
			</select>
		</li>
	</ul>
	</div>
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">

	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>There are no projects that are at the <i>{{ convert_path_to_stage($stage) }}</i> stage.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop