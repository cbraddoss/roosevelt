@extends('layout.main')

@section('page-h1')
{{ 'To-Do List' }}
@stop

@section('page-h2')
{{ $user->first_name.' '.$user->last_name.'\'s To-Do List' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('profile.partials.profile-menu')
		<li class="right select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-user todo-filter">
				@if(!empty($user)) {{ get_user_list_select($user->first_name.' '.$user->last_name) }} @else {{ get_user_list_select() }} @endif
			</select>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="todo-page"  class="inner-page">
	<h2>@yield('page-h2')
	<small class="count-of-total">[{{ count($projects) }} of {{ $projectsCount }}]</small></h2> <!-- add total count for other sections -->
	@if($projects->isEmpty())
		<h3>Projects:</h3>
			<div class="projects-post">
				@if(Auth::user()->id == $user->id)
				<h4>You are not currently assigned any projects.</h4>
				@else
				<h4>{{ $user->first_name }} {{ $user->last_name }} is not currently assigned any projects.</h4>
				@endif
				<p></p>
			</div>
	@else
		<h3>Projects:</h3>
		@include('projects.partials.findProjects')
	@endif

	@if(empty($billables))
		<h3>Billables:</h3>
			<div class="billables-post">
				@if(Auth::user()->id == $user->id)
				<h4>You are not currently assigned any billable items.</h4>
				@else
				<h4>{{ $user->first_name }} {{ $user->last_name }} is not currently assigned any billable items.</h4>
				@endif
				<p></p>
			</div>
	@else
		<h3>Billables:</h3>
		@include('billables.partials.findBillables')
	@endif

	@if(empty($helps))
		<h3>Help:</h3>
			<div class="helps-post">
				@if(Auth::user()->id == $user->id)
				<h4>You are not currently assigned any help items.</h4>
				@else
				<h4>{{ $user->first_name }} {{ $user->last_name }} is not currently assigned any help items.</h4>
				@endif
				<p></p>
			</div>
	@else
		<h3>Help:</h3>
		@include('helps.partials.findHelps')
	@endif

</div>
@stop