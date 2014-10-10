@extends('layout.main')

@section('page-title')
{{ 'Projects' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li><a id="pagelink-projects" href="/projects/status/open" class="link">Open</a></li>
		<li><a id="pagelink-projects-{{ Carbon::now()->format('F') }}" href="/projects/date/{{ Carbon::now()->format('Y') }}/{{ Carbon::now()->format('F') }}" class="link">Due {{ Carbon::now()->format('F') }}</a></li>
		<li><a id="pagelink-projects-{{ Auth::user()->user_path }}" href="/projects/assigned-to/{{ Auth::user()->user_path }}" class="link">Your Projects</a></li>
		<li class="right">
			<div id="projects-new-project-form" class="create-something-new">
				<div class="admin-button"><span class="projects-button add-button"><span class="ss-plus"> Add New</span></span></div>
			</div>
		</li>
		<li class="select-date right">
			<div class="filter-date projects-filter add-button" data-date="{{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
				<span class="ss-calendar"></span> <span>Date Filter</span>
			</div>
		</li>
		<li class="select-dropdown right">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-status projects-filter">
				<option value="0">Status Filter</option>
				<option value="open">Open</option>
				<option value="closed">Closed</option>
				<option value="archived">Archived</option>
			</select>
		</li>
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
			<select class="filter-priority projects-filter">
				<option value="0">Priority Filter</option>
				<option value="low">Low</option>
				<option value="normal">Normal</option>
				<option value="high">High</option>
			</select>
		</li>
		<li class="select-dropdown right">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-user projects-filter">
				<option value="0">User Filter</option>
				{{ get_user_list_select() }}
			</select>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">
	
	<h2>Open Projects:</h2>

	@include('projects.partials.findProjects')

</div>
@stop