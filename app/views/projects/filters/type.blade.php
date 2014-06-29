@extends('layout.main')

@section('page-title')
{{ 'Project Type - '. ucwords(str_replace('-',' ',$type)) . $tStatus }}
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
		<span class="page-menu-text">Filtering Type:</span>
	</li>
	<li class="select-dropdown">
		<span class="ss-dropdown"></span>
		<span class="ss-directup"></span>
		<select class="filter-type projects-filter">
			<option value="0">Type Filter</option>
			{{ $projectTypes }}
		</select>
	</li>
</ul>
</div>
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">

	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>There are no projects with a type of <i>{{ ucwords(str_replace('-',' ',$type)) }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop