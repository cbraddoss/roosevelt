<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>InsideOut Solutions</title>
	@include('layout.css')
</head>
<body>
	<div id="login-box">

		@if (Session::get('flash_message'))
		<div id="message">
				{{ Session::get('flash_message') }}
		</div>
		@endif

		<div id="login">
		<div class="login-image"><a href="/" target="_blank"><img src="/images/ios-logo2-clear.png" alt="InsideOut Solutions"></a></div>
		{{ Form::open(array('route' => 'sessions.store')) }}

			<div id="login-username" class="field-div">
				{{ Form::label('email','Email:') }}
				{{ Form::text('email', null, array('placeholder' => 'email address', 'class' => 'field', 'autofocus' => 'autofocus')) }}<span class="ss-user"></span>
			</div>
			<div id="login-password" class="field-div">
				{{ Form::label('password','Password:') }}
				{{ Form::password('password', array('placeholder' => 'password', 'class' => 'field')) }}<span class="ss-lock"></span>
			</div>
			<div id="login-submit" class="field-div">
				{{ Form::submit('Log In', array('class' => 'submit')) }}
			</div>		
		{{ Form::close() }}
		</div>

		<div id="login-subtext">
			<p class="lost-password-title"><a href="/password/remind/">Lost Password?</a></p>
		</div>

	</div>
@include('layout.js')
</body>
</html>