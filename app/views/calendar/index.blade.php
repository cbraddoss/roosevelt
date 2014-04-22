@extends('layout.main')

@section('page-title')
{{ 'Calendar' }}
@stop

@section('page-content')
<div id="calendar-page"  class="inner-page">
	@section('extra-menu')
	<li><a href="/calendar/" class="button calendar-today">Today</a></li>
	<li><span class="button calendar-jump-to">Jump to: </span><input type="text" class="datepicker calendar-jump-to-date" value="" placeholder="Month/Year" data-date-format="mm-yyyy" data-date-viewmode="months"></li>
	@stop

	<div class="calendar-header">
		<div class="month-arrow arrow-previous-month">
			<span class="ss-navigateleft"></span><a href="/calendar/{{ $previousMonthYear }}" class="show-previous-month">{{ preg_replace('/\d{4}\//','', $previousMonthYear) }}</a>
		</div>

		<div class="month-year">
			<h2>{{ $selectedMonth }} - {{ $selectedYear }}</h2>

			<div class="calendar-key">
				<div class="key-desc"><span class="key-color key-blue"></span><span class="key-title">News Article</span></div>
				<div class="key-desc"><span class="key-color key-orange"></span><span class="key-title">Projects</span></div>
				<div class="key-desc"><span class="key-color key-red"></span><span class="key-title">Tasks</span></div>
				<div class="key-desc"><span class="key-color key-green"></span><span class="key-title">Employee Vacations</span></div>
				<div class="key-desc"><span class="key-color key-purple"></span><span class="key-title">Employee Anniversary</span></div>
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