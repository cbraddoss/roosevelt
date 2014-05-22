@extends('emails.main')

@section('email-content')
<div class="content-div">
	<p>{{ $author }} pinged InsideOut in <b>{{ $title }}</b></p>
	<p>View the post here: <a href="{{ $link }}">{{ $title }}</a></p>
	<small>This post was created on {{ $created_at }}</small>
</div>
@stop