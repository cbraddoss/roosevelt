@extends('layout.main')

@section('page-title')
{{ 'Calendar - '. $selectedMonth .' - '. $selectedYear }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li><a href="/calendar/{{ $previousMonthYear }}" class="add-button show-previous-month"><span class="ss-navigateleft"></span> {{ preg_replace('/\d{4}\//','', $previousMonthYear) }}</a></li>
		<li><a href="/calendar/" class="add-button calendar-today">Go To Today</a></li>
		<li>
			<div class="calendar-jump-to-date filter-date calendar-filter" data-date="{{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
				<div><span class="jump-date add-button"><span class="ss-calendar"></span> Jump To</span></div>
			</div>
		</li>
		<li class="right"><a href="/calendar/{{ $nextMonthYear }}" class="add-button show-next-month navigateright">{{ preg_replace('/\d{4}\//','', $nextMonthYear) }} <span class="ss-navigateright"></span></a></li>
	</ul>
</div>
@stop

@section('page-content')
<div id="calendar-page"  class="inner-page">
	
	<div class="calendar-header">
		

		<div class="month-year">
			<div class="calendar-key">
				<div id="key-news-article" class="key-desc" toggleval="news-article-link"><span class="key-color key-news"></span><span class="key-title">News Article</span></div>
				<div id="key-projects" class="key-desc" toggleval="projects-post-link"><span class="key-color key-project"></span><span class="key-title">Project Launches</span></div>
				<div id="key-tasks" class="key-desc" toggleval="tasks-link"><span class="key-color key-tasks"></span><span class="key-title">Personal Tasks</span></div>
				<div id="key-employee-vacations" class="key-desc" toggleval="user-vacation-link"><span class="key-color key-vacations"></span><span class="key-title">Employee Vacations</span></div>
				<div id="key-employee-anniversary" class="key-desc" toggleval="user-anniversary-link"><span class="key-color key-anniversary"></span><span class="key-title">Employee Anniversary</span></div>
				<div class="key-desc"><small>[click to show/hide]</small></div>
			</div>
		</div>

		



	</div>

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