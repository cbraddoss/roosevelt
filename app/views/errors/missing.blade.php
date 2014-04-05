@extends('layout.main')

@section('page-title')
{{ 'Page Missing - 404' }}
@stop

@section('page-content')
<div id="fourOhFour-page"  class="inner-page">
	<p class="alert-icon"><span class="ss-alert"></span></p>
	<p>Oops, Page Not Found!</p>
	<p>Error: 404</p>
	<span>If you are expecting a page to be here, please let a devteam member know.</span>
</div>
@stop