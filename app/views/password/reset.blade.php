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

		@if (Session::has('error'))
		<div id="message">
				{{ Session::get('error') }}
		</div>
		@endif

		<div id="login">
		<div class="login-image"><a href="http://insideout.com/about-us/contact-us/" target="_blank"><img src="/images/ios-logo2-clear.png" alt="InsideOut Solutions"></a></div>
		{{ Form::open(array('class' => 'login-reset')) }}

			<input type="hidden" name="token" value="{{ $token }}">

			<div id="login-email" class="field-div">
				{{ Form::label('email','Email') }}
				{{ Form::email('email', null, array('placeholder' => 'email address', 'class' => 'field', 'autofocus' => 'autofocus')) }}<span class="ss-mail"></span>
			</div>
			
			<div id="login-password" class="field-div">
				{{ Form::label('password','Password') }}
				{{ Form::password('password', array('placeholder' => 'password', 'class' => 'field')) }}<span class="ss-lock"></span>
			</div>

			<div id="login-password-conf" class="field-div">
				{{ Form::label('password_confirmation','Password Confirmation') }}
				{{ Form::password('password_confirmation', array('placeholder' => 'password again', 'class' => 'field')) }}<span class="ss-lock"></span>
			</div>

			<div id="login-submit" class="field-div">
				{{ Form::submit('Request Reset', array('class' => 'submit')) }}
			</div>		
		{{ Form::close() }}
		</div>

		<div id="login-subtext">
			<p><a href="/login/">Login</a></p>
		</div>

	</div>
@include('layout.js')
</body>
</html>