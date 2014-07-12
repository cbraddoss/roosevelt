@extends('emails.main')

@section('email-content')
<div class="content-div">
	<p>{{ $author }} pinged InsideOut Solutions in a News post: <a href="{{ $link }}">{{ $title }}</a></p>
	<small>This post was created on {{ $created_at }}</small>
</div>
@stop