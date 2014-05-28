@extends('layout.main')

@section('page-title')
{{ 'Calendar' }}
@stop

@section('page-content')
<div id="calendar-page"  class="inner-page">
	<div class="page-menu">
	<div class="page-menu-arrow"></div>
		<ul>
			<li><a href="/calendar/" class="link calendar-today">Today</a></li>
			<li><span class="link calendar-jump-to">Jump to: </span><input type="text" class="datepicker calendar-jump-to-date" value="" placeholder="Month/Year" data-date-format="mm-yyyy" data-date-viewmode="months"></li>
		</ul>
	</div>

	<div class="calendar-header">
		<div class="month-arrow arrow-previous-month">
			<span class="ss-navigateleft"></span><a href="/calendar/{{ $previousMonthYear }}" class="show-previous-month">{{ preg_replace('/\d{4}\//','', $previousMonthYear) }}</a>
		</div>

		<div class="month-year">
			<h2>{{ $selectedMonth }} - {{ $selectedYear }}</h2>

			<div class="calendar-key">
				<div id="key-news-article" class="key-desc" toggleval="news-article-link"><span class="key-color key-blue"></span><span class="key-title">News Article</span></div>
				<div id="key-projects" class="key-desc" toggleval="project-link"><span class="key-color key-orange"></span><span class="key-title">Projects</span></div>
				<div id="key-tasks" class="key-desc" toggleval="tasks-link"><span class="key-color key-red"></span><span class="key-title">Tasks</span></div>
				<div id="key-employee-vacations" class="key-desc" toggleval="user-vacation-link"><span class="key-color key-green"></span><span class="key-title">Employee Vacations</span></div>
				<div id="key-employee-anniversary" class="key-desc" toggleval="user-anniversary-link"><span class="key-color key-purple"></span><span class="key-title">Employee Anniversary</span></div>
			</div>
		</div>

		<div class="month-arrow arrow-next-month">
			<a href="/calendar/{{ $nextMonthYear }}" class="show-next-month">{{ preg_replace('/\d{4}\//','', $nextMonthYear) }}</a><span class="ss-navigateright"></span>
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