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
		@elseif (Session::has('status'))
		<div id="message-success">
				{{ Session::get('status') }}
		</div>
		@endif

		<div id="login">
		<div class="login-image"><a href="/" target="_blank"><img src="/images/ios-logo2-clear.png" alt="InsideOut Solutions"></a></div>
		{{ Form::open() }}

			<div id="login-email" class="field-div">
				{{ Form::label('email','Email') }}
				{{ Form::email('email', null, array('placeholder' => 'email address', 'class' => 'field', 'autofocus' => 'autofocus')) }}<span class="ss-mail"></span>
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