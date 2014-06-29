@extends('layout.main')

@section('page-title')
{{ 'Projects' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li>
			<div id="projects-new-project-form" class="create-something-new">
				<span class="projects-button"><button class="add-new ss-plus">Add New</button></span>
			</div>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-status projects-filter">
				<option value="0">Status Filter</option>
				<option value="open">Open</option>
				<option value="closed">Closed</option>
				<option value="archived">Archived</option>
			</select>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-type projects-filter">
				<option value="0">Type Filter</option>
				{{ $projectTypes }}
			</select>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-priority projects-filter">
				<option value="0">Priority Filter</option>
				<option value="low">Low</option>
				<option value="normal">Normal</option>
				<option value="high">High</option>
			</select>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-user projects-filter">
				<option value="0">User Filter</option>
				{{ get_user_list_select() }}
			</select>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-stage projects-filter">
				<option value="0">Stage Filter</option>
				{{ $projectStages }}
			</select>
		</li>
		<li class="select-date">
			<div class="filter-date projects-filter" data-date="{{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
				<span>Date Filter:</span>
				<span class="ss-calendar"></span>
			</div>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">
	
	@include('projects.partials.sub-menu')

	@include('projects.partials.findProjects')

</div>
@stop