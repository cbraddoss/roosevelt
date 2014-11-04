@extends('layout.main')

@section('page-h1')
{{ 'Error Page' }}
@stop

@section('page-h2')
{{ 'Page Missing - 404' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li>
			<div class="report-something-new">
				<a class="add-button" href="mailto:devteam@insideout.com?subject=Remote Office 404 - Page: {{ current_page() }}"><span class="ss-mail"></span> Report 404</a>
			</div>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="fourOhFour-page"  class="inner-page">
	<p><a class="ss-reply" href="{{ URL::previous() }}">Back to previous page</a></p>
	<p class="alert-icon"><span class="ss-alert"></span></p>
	<p>Oops, Page Not Found!</p>
	<p>Error: 404</p>
	<span>If you feel you've reached a page that should be available, please <a href="mailto:devteam@insideout.com?subject=Remote Office 404">contact the DevTeam</a>.</span>
</div>
@stop