@extends('layout.main')

@section('page-title')
{{ 'Page Missing - 404' }}
@stop

@section('page-content')
<div id="fourOhFour-page"  class="inner-page">
	<p class="alert-icon"><span class="ss-alert"></span></p>
	<p>Oops, Page Not Found!</p>
	<p>Error: 404</p>
	<span>Check the Routes file or Controller file for the specific resource you are trying to access.</span>
</div>
@stop