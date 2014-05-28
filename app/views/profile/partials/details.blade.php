@extends('profile.index')

@section('profile-details')
<div class="page-menu">
	<div class="page-menu-arrow"></div>
	<ul>
	@if(Auth::user()->userrole == 'admin')
		<li><a href="/admin/" class="link">Admin</a></li>
	@endif
		<li><a href="/todo/{{ Auth::user()->user_path }}" class="link">Tasks</a></li>
		<li><a href="/projects/assigned/{{ Auth::user()->user_path }}" class="link">Projects</a></li>
		<li><a href="/billables/assigned/{{ Auth::user()->user_path }}" class="link">Billables</a></li>
		<li><a href="/help/assigned/{{ Auth::user()->user_path }}" class="link">Help</a></li>
	</ul>
	<div class="create-something-new">
		<a href="/profile/edit" id="{{ Auth::user()->id }}" class="button edit-profile">Edit Profile</a>
	</div>
</div>

<h3>Details</h3>
<div id="profile-details">
	<div class="profile-field">
		<span class="profile-title first-name">First Name:</span>
		<span class="profile-value first-name-value">{{ Auth::user()->first_name }}</span>
	</div>
	<div class="profile-field">
		<span class="profile-title last-name">Last Name:</span>
		<span class="profile-value last-name-value">{{ Auth::user()->last_name }}</span>
	</div>
	<div class="profile-field">
		<span class="profile-title email">Email:</span>
		<span class="profile-value email-value">{{ Auth::user()->email }}</span>
	</div>
	<div class="profile-field">
		<span class="profile-title extension">Extension:</span>
		<span class="profile-value extension-value">{{ Auth::user()->extension }}</span>
	</div>
	<div class="profile-field">
		<span class="profile-title cell-phone">Cell Phone:</span>
		<span class="profile-value cell-phone-value">{{ Auth::user()->cell_phone }}</span>
	</div>
	<div class="profile-field">
		<span class="profile-title password">Password:</span>
		<span class="profile-value password-value">********</span>
	</div>
	<div class="profile-field">
		<span class="profile-title user-stats">User Stats:</span>
		<span class="profile-value user-stats-value">You started working for InsideOut Solutions on <b>{{ Carbon::createFromFormat('Y-m-d H:i:s', Auth::user()->anniversary)->format('M d, Y') }}</b>!</span>
	</div>
</div>

<h3>Vacations</h3>
<div id="user-vacations">
	<div class="profile-field field-add-vacation-dates">
		<span class="profile-title vacation-add-dates">Add Dates:</span>
		{{ Form::open( array('class' => 'add-vacation-profile', 'route' => 'profile.vacation', 'method' => 'post', 'id' => Auth::user()->id) ) }}
		{{ Form::hidden('user_id', Auth::user()->id) }}
		{{ Form::select('period', array('full-day' => 'Full Day', 'half-day-am' => 'Half Day AM', 'half-day-pm' => 'Half Day PM') , 'standard') }}
		{{ Form::label('start_date', 'From:') }}
		{{ Form::text('start_date', null, array('placeholder' => 'Start Date', 'class' => 'datepicker vacation-date-add', 'id' => 'vacation-date-start')) }}
		{{ Form::label('end_date', 'To:') }}
		{{ Form::text('end_date', null, array('placeholder' => 'End Date', 'class' => 'datepicker vacation-date-add', 'id' => 'vacation-date-end')) }}
		{{ Form::submit('Add Vacation', array('class' => 'save-vacation-profile') ) }}
		{{ Form::close() }}

	</div>
	@if($vacationsUpcoming->isEmpty())
		<h4>Upcoming</h4>
		<div class="profile-field">
			<span class="profile-title vacation-dates">Dates:</span>
			<span class="profile-value vacation-dates-value">You don't have any vacation scheduled. Schedule some now!</span>
		</div>
	@else
		<h4>Upcoming</h4>
		@foreach($vacationsUpcoming as $vaca)
		<div class="profile-field">
			<span class="profile-title vacation-dates">Dates:</span>
			@if($vaca->period == 'half-day-am')
			<span class="profile-value vacation-dates-value"><a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('M d, Y') }}</a> (Half Day - AM)
			@elseif($vaca->period == 'half-day-pm')
			<span class="profile-value vacation-dates-value"><a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('M d, Y') }}</a> (Half Day - PM)
			@elseif($vaca->start_date == $vaca->end_date)
			<span class="profile-value vacation-dates-value"><a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('M d, Y') }}</a>
			@else
			<span class="profile-value vacation-dates-value">From <a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('M d, Y') }}</a> to <a href="/calendar/{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->end_date)->format('Y/F') }}">{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->end_date)->format('M d, Y') }}</a></span>
			@endif
			{{ Form::open( array('class' => 'remove-vacation-profile', 'route' => 'profile.vacation', 'method' => 'post', 'id' => $vaca->id) ) }}
			{{ Form::hidden('id', $vaca->id)}}
			{{ Form::hidden('delete-vacation', 'yes') }}
			{{ Form::submit('Delete', array('class' => 'delete-vacation-profile delete')) }}
			{{ Form::close() }}
		</div>
		@endforeach
	@endif
	
	@if($vacationsPrevious->isEmpty())
		<h4>Previous</h4>
		<div class="profile-field">
			<span class="profile-title vacation-dates">Dates:</span>
			<span class="profile-value vacation-dates-value">No past vacation dates found. Maybe some should be scheduled?!</span>
		</div>
	@else
		<h4>Previous</h4>
		@foreach($vacationsPrevious as $vaca)
		<div class="profile-field">
			<span class="profile-title vacation-dates">Dates:</span>
			<span class="profile-value vacation-dates-value">From <b>{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('M d, Y') }}</b> to <b>{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->end_date)->format('M d, Y') }}</b></span>
		</div>
		@endforeach
	@endif
</div>
@stop