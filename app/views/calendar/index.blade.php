@extends('layout.main')

@section('page-title')
{{ 'Calendar' }}
@stop

@section('page-content')
<div id="calendar-page"  class="inner-page">

	<div class="calendar-header">
		<div class="month-arrow arrow-previous-month">
			<span class="ss-navigateleft"></span><a href="/calendar/{{ $previousMonthYear }}" class="show-previous-month">{{ preg_replace('/\d{4}\//','', $previousMonthYear) }}</a>
		</div>

		<div class="month-year">
		<h2>{{ $selectedMonth }} - {{ $selectedYear }}</h2>
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