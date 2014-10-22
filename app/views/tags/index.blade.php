@extends('layout.main')

@section('page-h1')
{{ 'Tags' }}
@stop

@section('page-h2')
{{ $pageHeaderTwo }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('tags.partials.tags-menu')
	</ul>
</div>
@stop

@section('page-content')
<div id="tags-page"  class="inner-page">
	<h2>@yield('page-h2')
	<small class="count-of-total">[{{ count($tags) }} of {{ $tagsCount }}]</small></h2>
	@if($tags->isEmpty())
		<p>{{ $tagsNotFound }}</p>
	@else
		@include('tags.partials.findTags')
	@endif
</div>
@stop