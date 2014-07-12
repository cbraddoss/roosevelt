@extends('emails.main')

@section('email-content')
<div class="content-div">
	<p>Your article, <a href="{{ $link }}">{{ $title }}</a>, has a new reply by {{ $author }}</p>
	<small>This comment was created on {{ $created_at }}</small>
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