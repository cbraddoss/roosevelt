@extends('layout.main')

@section('page-h1')
{{ 'Projects' }}
@stop

@section('page-h2')
{{ ucwords($status) }} Projects
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('projects.partials.projects-menu')
		<li class="select-dropdown right">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-status projects-filter">
				<option value="0">Status Filter</option>
				@if(!empty($open)) <option value="open" selected>Open</option> @else <option value="open">Open</option> @endif
				@if(!empty($closed)) <option value="closed" selected>Closed</option> @else <option value="closed">Closed</option> @endif
				@if(!empty($archived)) <option value="archived" selected>Archived</option> @else <option value="archived">Archived</option> @endif
			</select>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">
	<h2>@yield('page-h2')</h2>
	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>There are no projects that are <i>{{ $status }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop