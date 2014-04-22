@extends('layout.main')

@section('page-title')
{{ Auth::user()->first_name }}{{ '\'s Profile' }}
@stop

@section('page-content')
<div id="profile-page"  class="inner-page">
	<h3>Details</h3>
	<div id="profile-header">
		<!-- <span class="user-image"><img src="{{ gravatar_url(Auth::user()->email,100) }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}"></span> -->
	</div>
	<div id="profile-details">
		@yield('profile-details')
	</div>

	<h3>Vacations</h3>
	<div id="user-vacations">
		@yield('profile-vacations')
	</div>
</div>
@stop