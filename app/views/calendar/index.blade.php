@extends('layout.main')

@section('page-title')
{{ 'Calendar' }}
@stop

@section('page-content')
<div id="calendar-page"  class="inner-page">

	<div class="calendar-header">
		<div class="arrow-previous-month month-arrow">
			<span class="ss-navigateleft"></span>
		</div>

		<div class="month-year">
		<h2>{{ Carbon::now()->format('F - Y') }}</h2>
		</div>

		<div class="arrow-next-month month-arrow">
			<span class="ss-navigateright"></span>
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
		{{ Carbon::now()->daysInMonth }}
			<span class="day">{{ Carbon::parse('first day of April 2014')->format('d') }}</span>		
		</div>

	</div>

</div>
@stop