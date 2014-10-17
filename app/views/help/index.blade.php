@extends('layout.main')

@section('page-h1')
{{ 'Help' }}
@stop

@section('page-h2')
{{ 'Help' }}
@stop

@section('header-menu')
	<div class="page-menu">
		<ul>
			<li><a id="pagelink-help" href="/help" class="link">Open</a></li>
			<li class="right">
				<div id="help-new-help-form" class="create-something-new">
					<div class="help-button"><span class="add-new add-button"><span class="ss-plus"></span> Help</span></div>
				</div>
			</li>
		</ul>
	</div>
@stop

@section('page-content')
<div id="help-page"  class="inner-page">
	<h2>@yield('page-h2')</h2>
	
	<h3>The gremlins are still assembling this page.</h3>
	<p>Check back soon.</p>
	
</div>
@stop