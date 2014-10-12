@extends('layout.main')

@section('page-h1')
{{ 'Projects' }}
@stop

@section('page-h2')
{{ ucwords(str_replace('-',' ',$type)) }} @if(!empty($tStatus)) {{ 'Projects ' . $tStatus . ':' }} @else {{ 'Projects:' }} @endif
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('projects.partials.projects-menu')
		<li class="select-dropdown right">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-type projects-filter">
				<option value="0">Type Filter</option>
				{{ $projectTypes }}
			</select>
		</li>
		<li class="select-dropdown right">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-stage projects-filter">
				<option value="0">Stage Filter</option>
				{{ $projectStages }}
			</select>
			<input type="hidden" value="{{ $type }}" />
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">
	<h2>@yield('page-h2')</h2>

	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>There are no projects with a type of <i>{{ ucwords(str_replace('-',' ',$type)) }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop