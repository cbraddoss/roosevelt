@extends('layout.main')

@section('page-title')
{{ 'Projects - Assigned To: '.$user->first_name.' '.$user->last_name }}
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">

@include('projects.partials.sub-menu')
	
	@if($projects->isEmpty())
			<div class="projects-post">
				<h3><i>{{ $user->first_name.' '.$user->last_name }}</i> is not assigned to any projects.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop