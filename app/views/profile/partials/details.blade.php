@extends('profile.index')

@section('profile-details')
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
	<div class="profile-field">
		<a href="/profile/edit" id="{{ Auth::user()->id }}" class="button edit-profile">Edit Profile</a>
	</div>
</div>

<h3>Vacations</h3>
<div id="user-vacations">
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
			<span class="profile-value vacation-dates-value">From <b>{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->start_date)->format('M d, Y') }}</b> to <b>{{ Carbon::createFromFormat('Y-m-d H:i:s', $vaca->end_date)->format('M d, Y') }}</b></span>
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