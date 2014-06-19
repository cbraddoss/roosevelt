@extends('layout.main')

@section('page-title')
{{ $user->first_name.' '.$user->last_name.' - To-Do List' }}
@stop

@section('header-menu')
	<div class="page-menu">
		<ul>
			<li>
				<div id="news-new-article-form" class="create-something-new">
					<span class="news-button"><button class="add-new ss-plus">Add New</button></span>
				</div>
			</li>
			<li><span class="page-menu-text">View: </span></li>
			<li class="select-dropdown">
				<span class="ss-dropdown"></span>
				<span class="ss-directup"></span>
				<select class="filter-user">
					@if(!empty($user)) {{ get_user_list_select($user->first_name.' '.$user->last_name) }} @else {{ get_user_list_select() }} @endif
				</select>
			</li>
		</ul>
	</div>
@stop

@section('page-content')
<div id="todo-page"  class="inner-page">

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