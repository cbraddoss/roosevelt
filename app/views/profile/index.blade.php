@extends('layout.main')

@section('page-h1')
{{ 'Profile' }}
@stop

@section('page-h2')
{{ Auth::user()->first_name }}{{ '\'s Profile' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('profile.partials.profile-menu')
	</ul>
</div>
@stop

@section('page-content')
<div id="profile-page"  class="inner-page">
	<h2>@yield('page-h2')</h2>

	<div id="profile-header">
		<!-- <span class="user-image"><img src="{{ gravatar_url(Auth::user()->email,100) }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}"></span> -->
	</div>
	<div class="profile-left">
		<h2>Details</h2>
		<div class="update-something-form">
			{{ Form::open( array('class' => 'update-profile', 'route' => 'profile.update', 'method' => 'post', 'id' => Auth::user()->id) ) }}

			{{ Form::hidden('id', Auth::user()->id) }}

			<div class="new-form-field">
				{{ Form::label('first_name','First Name:') }}
				{{ Form::text('first_name', Auth::user()->first_name, array('placeholder' => 'First Name', 'class' => 'first-name field')) }}
			</div>

			<div class="new-form-field">
				{{ Form::label('last_name','Last Name:') }}
				{{ Form::text('last_name', Auth::user()->last_name, array('placeholder' => 'Last Name', 'class' => 'last-name field')) }}
			</div>

			<div class="new-form-field">
				{{ Form::label('email','Email:') }}
				<label>{{ Auth::user()->email }}</label>
			</div>

			<div class="new-form-field">
				{{ Form::label('hipchat_mention','HipChat Nickname:') }}
				@if(empty(Auth::user()->hipchat_mention))
				{{ Form::label('hipchat_mention', 'Resave Profile to update.') }}
				@else
				{{ Form::label('hipchat_mention', '@'.Auth::user()->hipchat_mention) }}
				@endif
			</div>

			<div class="new-form-field">
				{{ Form::label('extension','Extension:') }}
				{{ Form::text('extension', Auth::user()->extension, array('placeholder' => '555', 'class' => 'extension field')) }}
			</div>

			<div class="new-form-field">
				{{ Form::label('cell_phone','Cell Phone:') }}
				{{ Form::text('cell_phone', Auth::user()->cell_phone, array('placeholder' => '555-555-5555', 'class' => 'cell-phone field')) }}
			</div>

			<div class="new-form-field">
				{{ Form::label('password','New Password:') }}
				{{ Form::password('password', array('placeholder' => 'New Password', 'class' => 'password field')) }}
			</div>

			<div class="new-form-field">
				{{ Form::label('password_again','New Password Again:') }}
				{{ Form::password('password_again', array('placeholder' => 'New Password Again', 'class' => 'password_again field')) }}
			</div>

				{{ Form::submit('Save Profile', array('class' => 'save-profile form-button') ) }}

				<a href="/profile" class="form-button cancel">Cancel</a>

			{{ Form::close() }}
		</div>
	</div>
	<div class="profile-right">
	<h2>Vacations</h2>
	<div id="vacations">
<div class="field-add-vacation-dates">
<div class="update-something-form">
{{ Form::open( array('class' => 'add-vacation-profile', 'route' => 'profile.vacation', 'method' => 'post', 'id' => Auth::user()->id) ) }}
{{ Form::hidden('user_id', Auth::user()->id) }}
			
<div class="new-form-field">
{{ Form::label('period','Period:') }}
<div class="select-dropdown">
<span class="ss-dropdown"></span>
<span class="ss-directup"></span>
{{ Form::select('period', array('full-day' => 'Full Day', 'half-day-am' => 'Half Day AM', 'half-day-pm' => 'Half Day PM') , 'standard') }}
</div>
</div>
<div class="new-form-field">
{{ Form::label('start_date', 'From:') }}
{{ Form::text('start_date', null, array('placeholder' => 'Start Date', 'class' => 'datepicker vacation-date-add', 'id' => 'vacation-date-start')) }}
</div>
<div class="new-form-field">
{{ Form::label('end_date', 'To:') }}
{{ Form::text('end_date', null, array('placeholder' => 'End Date', 'class' => 'datepicker vacation-date-add', 'id' => 'vacation-date-end')) }}
</div>
{{ Form::submit('Add Vacation', array('class' => 'save-vacation-profile form-button') ) }}
{{ Form::close() }}

@if($vacationsUpcoming->isEmpty())
<div class="vacation-box vacation-upcoming">
<h3>Upcoming</h3>
<p>You don't have any vacation scheduled. Schedule some now!</p>
</div>
@else
<div class="vacation-box vacation-upcoming">
<h3>Upcoming</h3>
@foreach($vacationsUpcoming as $vaca)
<div class="vacation-details">
@if($vaca->period == 'half-day-am')
<span><a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('M d, Y') }}</a></span><span>(Half Day - AM)</span>
@elseif($vaca->period == 'half-day-pm')
<span><a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('M d, Y') }}</a></span><span>(Half Day - PM)</span>
@elseif($vaca->start_date == $vaca->end_date)
<span><a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('M d, Y') }}</a></span><span>(Full Day)</span>
@else
<span>Start: <a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('M d, Y') }}</a></span><span>End: <a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->end_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->end_date)->format('M d, Y') }}</a></span>
@endif
<div class="update-something-form">
{{ Form::open( array('class' => 'remove-vacation-profile delete-post', 'route' => 'profile.vacation', 'method' => 'post', 'id' => $vaca->id) ) }}
{{ Form::hidden('id', $vaca->id)}}
{{ Form::hidden('delete-vacation', 'yes') }}
{{ Form::submit('Delete', array('class' => 'delete-vacation-profile delete form-button')) }}
{{ Form::close() }}
</div>
</div>
@endforeach
<div class="clear"></div>
</div>
@endif

@if($vacationsPrevious->isEmpty())
<div class="vacation-box vacation-previous">
<h3>Previous</h3>
<p>No past vacation dates found. Maybe some should be scheduled?!</p>
</div>
@else
<div class="vacation-box vacation-previous">
<h3>Previous</h3>
@foreach($vacationsPrevious as $vaca)
<div class="vacation-details">
@if($vaca->period == 'half-day-am')
<span><a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('M d, Y') }}</a></span><span>(Half Day - AM)</span>
@elseif($vaca->period == 'half-day-pm')
<span><a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('M d, Y') }}</a></span><span>(Half Day - PM)</span>
@elseif($vaca->start_date == $vaca->end_date)
<span><a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('M d, Y') }}</a></span><span>(Full Day)</span>
@else
<span>Start: <a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('M d, Y') }}</a></span><span>End: <a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->end_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->end_date)->format('M d, Y') }}</a></span>
@endif
</div>
@endforeach
<div class="clear"></div>
</div>
@endif
</div>
</div>
		</div>
	</div>
	
</div>
@stop