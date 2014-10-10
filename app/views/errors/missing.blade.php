@extends('layout.main')

@section('page-title')
{{ 'Page Missing - 404' }}
@stop

@section('page-content')
<div id="fourOhFour-page"  class="inner-page">
	<p><a class="ss-reply" href="{{ URL::previous() }}">Back to previous page</a></p>
	<p class="alert-icon"><span class="ss-alert"></span></p>
	<p>Oops, Page Not Found!</p>
	<p>Error: 404</p>
	<span>If you feel you've reached a page that should be available, please <a href="mailto:devteam@insideout.com?subject=Remote Office 404">contact a DevTeam associate</a>.</span>
</div>
@stop