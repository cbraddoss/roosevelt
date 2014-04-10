@extends('profile.index')

@section('profile-details')
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
	<span class="profile-value user-stats-value">Interesting user stats for {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}.</span>
</div>
<div class="profile-field">
	<a href="/profile/edit" id="{{ Auth::user()->id }}" class="button edit-profile">Edit Profile</a>
</div>
@stop