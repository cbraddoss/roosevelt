@extends('emails.main')

@section('email-content')
<h2>Password Reset</h2>

<div>
	<p>To reset your password, complete this form: {{ URL::to('password/reset', array($token)) }}.</p>
	<p>
	<small>This request was sent from the IP address <i>{{ $_SERVER['REMOTE_ADDR'] }}</i> using {{ $_SERVER['HTTP_USER_AGENT'] }}.</small>
	<small>If this is not your IP address and/or the browser you are using, please notify the DevTeam.</small>
	</p>
</div>
@stop