@extends('layout.main')

@section('page-h1')
{{ 'Projects' }}
@stop

@section('page-h2')
{{ 'Projects Due '. $date  }}
@stop

@section('header-menu')
	<div class="page-menu">
	<ul>
		@include('projects.partials.projects-menu')
		<li class="right">
			<div filterlink="/projects/date/" class="filter-this-date filter-date projects-filter add-button" data-date=" {{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
				<span class="ss-calendar"></span>
				<span>@if(!empty($date)) {{ $date }} @else Date Filter: @endif</span>
			</div>
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
				<h3>No projects due in <i>{{ $date }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop