@extends('layout.main')

@section('page-title')
{{ 'Projects - All '. ucwords($status) }}
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">

@include('projects.partials.sub-menu')
	
	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>There are no projects that are <i>{{ $status }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop