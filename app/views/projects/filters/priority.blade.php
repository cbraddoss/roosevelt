@extends('layout.main')

@section('page-title')
{{ 'Projects - '. ucwords($priority) .' priority' }}
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
			<span class="page-menu-text">Filtering Priority:</span>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-priority">
				<option value="0">Priority Filter</option>
				@if(!empty($low)) <option value="low" selected>Low</option> @else <option value="low">Low</option> @endif
				@if(!empty($normal)) <option value="normal" selected>Normal</option> @else <option value="normal">Normal</option> @endif
				@if(!empty($high)) <option value="high" selected>High</option> @else <option value="high">High</option> @endif
			</select>
		</li>
	</ul>
	</div>

	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>There are no projects with a priority of <i>{{ $priority }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop