@extends('emails.main')

@section('email-content')
<div class="content-div">
	<p>Your article, <b>{{ $title }}</b>, has a new reply by {{ $author }}</p>
	<p>View the comment here: <a href="{{ $link }}">{{ $title }}</a></p>
	<small>This comment was created on {{ $created_at }}</small>
</div>
<div class="activity-div">
	<h4>Your Current Activity:</h4>
	<ul>
		<li><a href="{{ URL::to('/tasks/') }}">{{ $tasks }} Tasks</a></li>
		<li><a href="{{ URL::to('/projects/') }}">{{ $projects }} Projects</a></li>
		<li><a href="{{ URL::to('/billables/') }}">{{ $billables }} Billables</a></li>
		<li><a href="{{ URL::to('/help/') }}">{{ $help }} Help</a></li>
	</ul>
</div>
@stop