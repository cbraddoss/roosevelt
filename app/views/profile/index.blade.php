@extends('layout.main')

@section('page-title')
{{ Auth::user()->first_name }}{{ '\'s Profile' }}
@stop

@section('page-content')
<div id="profile-page"  class="inner-page">
	
	<div id="profile-header">
		<span class="user-image"><img src="{{ gravatar_url(Auth::user()->email,100) }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}"></span>
	</div>
	<div id="profile-details">
		@if(Session::get('flash_message_error'))
			<div class="profile-field message"><span class="flash-message flash-message-error"><span class="ss-alert"></span> {{ Session::get('flash_message_error') }}</span></div>
		@endif
		@foreach ($errors->all() as $error)
			<div class="profile-field message"><span class="flash-message flash-message-error"><span class="ss-alert"></span>{{ $error }}</span></div>
		@endforeach
		@if(Session::get('flash_message_success'))
			<div class="profile-field message"><span class="flash-message flash-message-success"><span class="ss-check"></span> {{ Session::get('flash_message_success') }}</span></div>
		@endif
		</div>
		@yield('profile-details')
	</div>
</div>
@stop