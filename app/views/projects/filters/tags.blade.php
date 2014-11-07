@extends('layout.main')

@section('page-h1')
{{ 'Projects' }}
@stop

@section('page-h2')
{{ 'Project Tag: ' . ucwords($tag->name)  }}
@stop

@section('header-menu')
	<div class="page-menu">
	<ul>
		@include('projects.partials.projects-menu')
		<li class="right select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select filterlink="/projects/tag/" class="filter-this filter-vault-tag tags-filter">
				<option>Tag Filter</option>
				{{ $projectsTagsSelect }}
			</select>
		</li>
	</ul>
	</div>
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">
	<h2>@yield('page-h2')
	<small class="count-of-total">[{{ count($projects) }} of {{ $projectsCount }}]</small></h2>
	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>No projects with tag {{ ucwords($tag->name) }} found.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop