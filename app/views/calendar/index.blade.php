@extends('layout.main')

@section('page-title')
{{ 'Calendar - '. $selectedMonth .' - '. $selectedYear }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li>
			<div class="navigate-something">
				<div class="anchor-button"><a href="/calendar/{{ $previousMonthYear }}" class="show-previous-month"><span class="ss-navigateleft"></span>{{ preg_replace('/\d{4}\//','', $previousMonthYear) }}</a></div>
			</div>
		</li>
		<li>
			<div class="navigate-something">
				<div class="anchor-button"><a href="/calendar/" class="calendar-today">Go To Today</a></div>
			</div>
		</li>
		<li>
			<div class="calendar-jump-to-date filter-date calendar-filter" data-date="{{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
				<span>Jump to:</span>
				<span class="ss-calendar"></span>
			</div>
		</li>
		<li>
			<div class="navigate-something">
				<div class="anchor-button"><a href="/calendar/{{ $nextMonthYear }}" class="show-next-month navigateright">{{ preg_replace('/\d{4}\//','', $nextMonthYear) }}<span class="ss-navigateright"></span></a></div>
			</div>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="calendar-page"  class="inner-page">
	
	<div class="calendar-header">
		

		<div class="month-year">
			<div class="calendar-key">
				<div id="key-news-article" class="key-desc" toggleval="news-article-link"><span class="key-color key-blue"></span><span class="key-title">News Article</span></div>
				<div id="key-projects" class="key-desc" toggleval="projects-post-link"><span class="key-color key-orange"></span><span class="key-title">Projects</span></div>
				<div id="key-tasks" class="key-desc" toggleval="tasks-link"><span class="key-color key-red"></span><span class="key-title">Tasks</span></div>
				<div id="key-employee-vacations" class="key-desc" toggleval="user-vacation-link"><span class="key-color key-green"></span><span class="key-title">Employee Vacations</span></div>
				<div id="key-employee-anniversary" class="key-desc" toggleval="user-anniversary-link"><span class="key-color key-purple"></span><span class="key-title">Employee Anniversary</span></div>
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