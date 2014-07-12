@extends('emails.main')

@section('email-content')
<div class="content-div">
	<p>You have been subscribed by {{ $author }} to project: <a href="{{ $link }}">{{ $title }}</a></p>
	<p>This project is tentatively scheduled to launch on {{ $launch_date }}</p>
	<small>Note: You can manage your subscriptions on each project.</small>
	<small>This post was created on {{ $created_at }}</small>
</div>
<div class="activity-div">
	<h4>Your Current Activity:</h4>
	<ul>
		<li>{{ $tasks }} <span>Tasks</span></li>
		<li>{{ $projects }} <span>Projects</span></li>
		<li>{{ $billables }} <span>Billables</span></li>
		<li>{{ $help }} <span>Help</span></li>
	</ul>
</div>
@stop