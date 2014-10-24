@extends('emails.main')

@section('email-content')
<div class="content-div">
	<p>You have been pinged by {{ $author }} in a News post: <a href="{{ $link }}">{{ $title }}</a></p>
	<small>This post was created on {{ $created_at }}</small>
</div>
<div class="activity-div">
	<h4>Your Current Activity:</h4>
	<ul>
		<li>{{ $tasks }} <span>To-Do</span></li>
		<li>{{ $projects }} <span>Projects</span></li>
		<li>{{ $billables }} <span>Billables</span></li>
		<li>{{ $help }} <span>Help</span></li>
	</ul>
</div>
@stop