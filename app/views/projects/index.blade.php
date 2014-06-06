@extends('layout.main')

@section('page-title')
{{ 'Projects' }}
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">
	
	@include('projects.partials.sub-menu')

	@include('projects.partials.findProjects')

</div>
@stop