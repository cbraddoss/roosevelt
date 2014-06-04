@extends('profile.index')

@section('profile-details')
<div class="page-menu">
	<ul>
	@if(Auth::user()->userrole == 'admin')
		<li><a href="/admin/" class="link">Admin</a></li>
	@endif
		<li><a href="/todo/{{ Auth::user()->user_path }}" class="link">Tasks</a></li>
		<li><a href="/projects/assigned/{{ Auth::user()->user_path }}" class="link">Projects</a></li>
		<li><a href="/billables/assigned/{{ Auth::user()->user_path }}" class="link">Billables</a></li>
		<li><a href="/help/assigned/{{ Auth::user()->user_path }}" class="link">Help</a></li>
	</ul>
</div>
{{ Form::open( array('class' => 'update-profile', 'route' => 'profile.update', 'method' => 'post', 'id' => Auth::user()->id) ) }}

{{ Form::hidden('id', Auth::user()->id) }}

<div class="profile-field">
	<span class="profile-title first-name">{{ Form::label('first_name','First Name:') }}</span>
	<span class="profile-value first-name-value">{{ Form::text('first_name', Auth::user()->first_name, array('placeholder' => 'First Name', 'class' => 'first-name field')) }}</span>
</div>
<div class="profile-field">
	<span class="profile-title last-name">{{ Form::label('last_name','Last Name:') }}</span>
	<span class="profile-value last-name-value">{{ Form::text('last_name', Auth::user()->last_name, array('placeholder' => 'Last Name', 'class' => 'last-name field')) }}</span>
</div>
<div class="profile-field">
	<span class="profile-title email">Email:</span>
	<span class="profile-value email-value">{{ Auth::user()->email }}</span>
</div>
<div class="profile-field">
	<span class="profile-title extension">{{ Form::label('extension','Extension:') }}</span>
	<span class="profile-value extension-value">{{ Form::text('extension', Auth::user()->extension, array('placeholder' => '555', 'class' => 'extension field')) }}</span>
</div>
<div class="profile-field">
	<span class="profile-title cell-phone">{{ Form::label('cell_phone','Cell Phone:') }}</span>
	<span class="profile-value cell-phone-value">{{ Form::text('cell_phone', Auth::user()->cell_phone, array('placeholder' => '555-555-5555', 'class' => 'cell-phone field')) }}</span>
</div>
<div class="profile-field">
	<span class="profile-title password">{{ Form::label('password','New Password:') }}</span>
	<span class="profile-value password-value">{{ Form::password('password', array('placeholder' => 'New Password', 'class' => 'password field')) }}</span>
</div>
<div class="profile-field">
	<span class="profile-title password">{{ Form::label('password_again','New Password Again:') }}</span>
	<span class="profile-value password-value">{{ Form::password('password_again', array('placeholder' => 'New Password Again', 'class' => 'password_again field')) }}</span>
</div>
<div class="profile-field">
	{{ Form::submit('Save User', array('class' => 'save-profile') ) }}
</div>
<div class="profile-field">
	<a href="/profile" class="button cancel">Cancel</a>
</div>

{{ Form::close() }}

@stop