@extends('layout.main')

@section('page-h1')
{{ 'Projects' }}
@stop

@section('page-h2')
{{ ucwords($priority) .' Priority' }} Projects
@stop

@section('header-menu')
	<div class="page-menu">
	<ul>
		@include('projects.partials.projects-menu')
		<li class="select-dropdown right">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select filterlink="/projects/priority/" class="filter-this filter-priority projects-filter">
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
	<h2>@yield('page-h2')
	<small class="count-of-total">[{{ count($projects) }} of {{ $projectsCount }}]</small></h2>
	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>There are no projects with a priority of <i>{{ $priority }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop