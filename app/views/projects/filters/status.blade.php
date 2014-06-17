@extends('layout.main')

@section('page-title')
{{ 'Projects - All '. ucwords($status) }}
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
			<span class="page-menu-text">Filtering Status:</span>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-status">
				<option value="0">Status Filter</option>
				@if(!empty($open)) <option value="open" selected>Open</option> @else <option value="open">Open</option> @endif
				@if(!empty($closed)) <option value="closed" selected>Closed</option> @else <option value="closed">Closed</option> @endif
				@if(!empty($archived)) <option value="archived" selected>Archived</option> @else <option value="archived">Archived</option> @endif
			</select>
		</li>
	</ul>
	</div>

	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>There are no projects that are <i>{{ $status }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop