@extends('layout.main')

@section('page-title')
{{ 'Projects - Due in '. $date  }}
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">

@include('projects.partials.sub-menu')
	
	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>No projects due in <i>{{ $date }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop