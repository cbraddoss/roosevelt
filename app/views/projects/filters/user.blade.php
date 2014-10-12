@extends('layout.main')

@section('page-h1')
{{ 'Projects' }}
@stop

@section('page-h2')
Projects for {{ $user->first_name.' '.$user->last_name }}
@stop

@section('header-menu')
	<div class="page-menu">
	<ul>
		@include('projects.partials.projects-menu')
		<li class="select-dropdown right">
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
	<h2>@yield('page-h2')</h2>
	@if($projects->isEmpty())
			<div class="projects-post">
				<h3><i>{{ $user->first_name.' '.$user->last_name }}</i> is not assigned to any projects.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop