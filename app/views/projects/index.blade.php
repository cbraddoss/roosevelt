@extends('layout.main')

@section('page-h1')
{{ 'Projects' }}
@stop

@section('page-h2')
{{ 'Open Projects' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('projects.partials.projects-menu')
		<li class="select-date right">
			<div filterlink="/projects/date/" class="filter-this-date filter-date projects-filter add-button" data-date="{{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
				<span class="ss-calendar"></span> <span>Date Filter</span>
			</div>
		</li>
		<li class="select-dropdown right">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select filterlink="/projects/status/" class="filter-this filter-status projects-filter">
				<option value="0">Status Filter</option>
				<option value="open">Open</option>
				<option value="closed">Closed</option>
				<option value="archived">Archived</option>
			</select>
		</li>
		<li class="select-dropdown right">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select filterlink="/projects/type/" class="filter-this filter-type projects-filter">
				<option value="0">Type Filter</option>
				{{ $projectTypes }}
			</select>
		</li>
		<li class="select-dropdown right">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select filterlink="/projects/priority/" class="filter-this filter-priority projects-filter">
				<option value="0">Priority Filter</option>
				<option value="low">Low</option>
				<option value="normal">Normal</option>
				<option value="high">High</option>
			</select>
		</li>
		<li class="select-dropdown right">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select filterlink="/projects/assigned-to/" class="filter-this filter-user projects-filter">
				<option value="0">User Filter</option>
				{{ get_user_list_select() }}
			</select>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">
	<h2>@yield('page-h2')
	<small class="count-of-total">[{{ count($projects) }} of {{ $projectsCount }}]</small></h2>

	@include('projects.partials.findProjects')

</div>
@stop