@extends('layout.main')

@section('page-title')
{{ 'Page Missing - 404' }}
@stop

@section('page-content')
<div id="fourOhFour-page"  class="inner-page">
	<p><a href="{{ URL::previous() }}"><span class="ss-reply">Back to previous page</span></a></p>
	<p class="alert-icon"><span class="ss-alert"></span></p>
	<p>Oops, Page Not Found!</p>
	<p>Error: 404</p>
	<span>If you feel you've reached a page that should be available, please contact a DevTeam associate.</span>
</div>
@stop