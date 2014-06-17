@extends('layout.main')

@section('page-title')
{{ 'Projects - Due in '. $date  }}
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
			<span class="page-menu-text">Filtering Date:</span>
		</li>
		<li>
			<div class="filter-date" data-date=" {{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
				<span>@if(!empty($date)) {{ $date }} @elseDate Filter: @endif</span>
				<span class="ss-calendar"></span>
			</div>
		</li>
	</ul>
	</div>

	@if($projects->isEmpty())
			<div class="projects-post">
				<h3>No projects due in <i>{{ $date }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('projects.partials.findProjects')

</div>
@stop