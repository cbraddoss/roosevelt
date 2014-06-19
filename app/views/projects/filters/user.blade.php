@extends('layout.main')

@section('page-title')
{{ 'Projects - Assigned To: '.$user->first_name.' '.$user->last_name }}
@stop

@section('header-menu')
	<div class="page-menu">
	<ul>
		<li>
			<div id="projects-new-project-form" class="create-something-new">
				<span class="projects-button"><button class="add-new ss-plus">Add New</button></span>
			</div>
		</li>
		<li>
			<span class="page-menu-text">Filtering User:</span>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-user projects-filter">
				<option value="0">User Filter</option>
				@if(!empty($user)) {{ get_user_list_select($user->first_name.' '.$user->last_name) }} @else {{ get_user_list_select() }} @endif
			</select>
		</li>
	</ul>
	</div>
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">

	@if($projects->isEmpty())
			<div class="projects-post">
				<h3><i>{{ $user->first_name.' '.$user->last_name }}</i> is not assigned to any projects.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop