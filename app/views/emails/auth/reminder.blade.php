@extends('emails.main')

@section('email-content')
<div class="content-div">
	<h2>Password Reset</h2>
	<p>To reset your password, complete this form: {{ URL::to('password/reset', array($token)) }}.</p>
	<br />
	<p>
	<small>This request was sent from the IP address <i>{{ current_ip() }}</i>.</small>
	</p>
	<p>
	<small>Browser: {{ current_browser() }}.</small>
	</p>
	<p>
	<small>If this is not your IP address and/or browser, please notify the DevTeam.</small>
	</p>
</div>
@stop