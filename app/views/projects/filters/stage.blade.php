@extends('layout.main')

@section('page-title')
{{ 'Projects at stage: '. ucwords(str_replace('-',' ', $stage)) }}
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">

<!-- @include('projects.partials.sub-menu') -->
	<div class="page-home">
		<a href="/projects"><span class="ss-list"></span></a>
	</div>
	<div class="page-return">
		<a href="{{ URL::previous() }}"><span class="ss-reply"></span></a>
	</div>
	<div class="page-menu">
	<ul>
		<li>
			<span class="ss-filter"></span>
			<span class="page-menu-text">Filtering Stage:</span>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-stage">
				<option value="0">Stage Filter</option>
				@if(!empty($stage)) {{ get_project_stage_select($stage) }} @else {{ get_project_stage_select() }} @endif
			</select>
		</li>
	</ul>
	</div>

	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>There are no projects that are at the <i>{{ ucwords($stage) }}</i> stage.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop