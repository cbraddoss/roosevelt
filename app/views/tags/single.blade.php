@extends('layout.main')

@section('page-h1')
{{ 'Tags' }}
@stop

@section('page-h2')
{{ ucwords($tag->name) }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('tags.partials.tags-menu')
	</ul>
</div>
@stop

@section('page-content')
<div id="tags-page"  class="single-page inner-page">
	<h2>@yield('page-h2')</h2>
	
	<p>Display different resources using this tag here.</p>
	
</div>
@stop