@extends('layout.main')

@section('page-title')
{{ 'Project Type - '. ucwords(str_replace('-',' ',$type)) . $tStatus }}
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
			<span class="page-menu-text">Filtering Type:</span>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-type">
				<option value="0">Type Filter</option>
				@if(!empty($type)) {{ get_project_type_select($type) }} @else {{ get_project_type_select() }} @endif
			</select>
		</li>
	</ul>
	</div>

	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>There are no projects with a type of <i>{{ $type }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop