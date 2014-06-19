@extends('layout.main')

@section('page-title')
{{ 'Projects - Due in '. $date  }}
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
			<span class="page-menu-text">Filtering Date:</span>
		</li>
		<li>
			<div class="filter-date projects-filter" data-date=" {{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
				<span>@if(!empty($date)) {{ $date }} @elseDate Filter: @endif</span>
				<span class="ss-calendar"></span>
			</div>
		</li>
	</ul>
	</div>
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">

	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>No projects due in <i>{{ $date }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop