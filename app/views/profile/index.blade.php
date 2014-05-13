@extends('layout.main')

@section('page-title')
{{ Auth::user()->first_name }}{{ '\'s Profile' }}
@stop

@section('page-content')
<div id="profile-page"  class="inner-page">

	@section('extra-menu')
		@if(Auth::user()->userrole == 'admin')
		<li class="button"><a href="/admin/">Admin</a></li>
		@endif
	@stop

	<div id="profile-header">
		<!-- <span class="user-image"><img src="{{ gravatar_url(Auth::user()->email,100) }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}"></span> -->
	</div>
	
	@yield('profile-details')
	
</div>
@stop