@extends('layout.main')

@section('page-title')
{{ $user->first_name.'\'s To-Do List' }}
@stop

@section('page-content')
<div id="todo-page"  class="inner-page">
	
	<div class="page-menu">
		<ul>
			<li><a href="/to-do/{{ Auth::user()->user_path }}" class="link">To-Do</a></li>
			<li><a href="/projects/assigned-to/{{ Auth::user()->user_path }}" class="link">Projects</a></li>
			<li><a href="/billables/assigned-to/{{ Auth::user()->user_path }}" class="link">Billables</a></li>
			<li><a href="/help/assigned-to/{{ Auth::user()->user_path }}" class="link">Help</a></li>
		@if(Auth::user()->userrole == 'admin')
			<li><a href="/admin/" class="link">Admin</a></li>
		@endif
			<li>
				<select class="filter-user">
					@if(!empty($user)) {{ get_user_list_select($user->first_name.' '.$user->last_name) }} @else {{ get_user_list_select() }} @endif
				</select>
			</li>
		</ul>
	</div>

	@if($projects->isEmpty())
		<h3>Projects:</h3>
			<div class="projects-post">
				<h4>You are currently not assigned any projects.</h4>
				<p></p>
			</div>
	@else
		<h3>Projects:</h3>
		@include('projects.partials.findProjects')
	@endif

	@if(empty($billables))
		<h3>Billables:</h3>
			<div class="billables-post">
				<h4>You are currently not assigned any billable items.</h4>
				<p></p>
			</div>
	@else
		<h3>Billables:</h3>
		@include('billables.partials.findBillables')
	@endif

	@if(empty($helps))
		<h3>Help:</h3>
			<div class="helps-post">
				<h4>You are currently not assigned any help items.</h4>
				<p></p>
			</div>
	@else
		<h3>Help:</h3>
		@include('helps.partials.findHelps')
	@endif

</div>
@stop