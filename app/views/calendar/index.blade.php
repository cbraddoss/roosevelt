@extends('layout.main')

@section('page-h1')
{{ 'Calendar - '. $selectedMonth .' '. $selectedYear }}
@stop

@section('page-h2')
{{ 'Calendar - '. $selectedMonth .' '. $selectedYear }}
@stop

@section('page-title')
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li><a href="/calendar/{{ $previousMonthYear }}" class="add-button show-previous-month"><span class="ss-navigateleft"></span> {{ preg_replace('/\d{4}\//','', $previousMonthYear) }}</a></li>
		<li><a href="/calendar/" class="add-button calendar-today">Go To Today</a></li>
		<li>
			<div filterlink="/calendar/" class="filter-this-date calendar-jump-to-date filter-date calendar-filter" data-date="{{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
				<div><span class="jump-date add-button"><span class="ss-calendar"></span> Jump To</span></div>
			</div>
		</li>
		<li class="right"><a href="/calendar/{{ $nextMonthYear }}" class="add-button show-next-month navigateright">{{ preg_replace('/\d{4}\//','', $nextMonthYear) }} <span class="ss-navigateright"></span></a></li>
		
		<li class="select-dropdown right">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="show-hide-calendar">
				<option value="show-all">Show All</option>
				<option value="news-article-link">News Article</option>
				<option value="projects-post-link">Project Launches</option>
				<option value="tasks-link">Personal Tasks</option>
				<option value="user-vacation-link">Employee Vacations</option>
				<option value="user-anniversary-link">Employee Anniversary</option>
				<option value="hide-all">Hide All</option>
			</select>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="calendar-page"  class="inner-page">

	<div class="calendar-days">

		<div class="days-of-week">
			<span class="day">Sunday</span>
			<span class="day">Monday</span>
			<span class="day">Tuesday</span>
			<span class="day">Wednesday</span>
			<span class="day">Thursday</span>
			<span class="day">Friday</span>
			<span class="day">Saturday</span>
		</div>

		<div class="days-of-month">
			
			{{ $calendarShow }}	
			
		</div>

	</div>

</div>
@stop