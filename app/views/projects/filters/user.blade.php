@extends('layout.main')

@section('page-title')
{{ 'Projects - Assigned To: '.$user->first_name.' '.$user->last_name }}
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
			<span class="page-menu-text">Filtering User:</span>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-user">
				<option value="0">User Filter</option>
				@if(!empty($user)) {{ get_user_list_select($user->first_name.' '.$user->last_name) }} @else {{ get_user_list_select() }} @endif
			</select>
		</li>
	</ul>
	</div>

	@if($projects->isEmpty())
			<div class="projects-post">
				<h3><i>{{ $user->first_name.' '.$user->last_name }}</i> is not assigned to any projects.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop