@extends('layout.main')

@section('page-h1')
{{ 'Billables' }}
@stop

@section('page-h2')
{{ 'Open Billables' }}
@stop

@section('header-menu')
	<div class="page-menu">
		<ul>
			<li><a id="pagelink-billables" href="/billables" class="link">Open</a></li>
			<li class="right">
				<div id="billables-new-billable-form" class="create-something-new">
					<div class="billables-button"><span class="add-new add-button"><span class="ss-plus"></span> Billable</span></div>
				</div>
			</li>
		</ul>
	</div>
@stop

@section('page-content')
<div id="billables-page"  class="inner-page">
	<h2>@yield('page-h2')</h2>
	
	<h3>Internet gremlins are still assembling this page.</h3>
	<p>Check back soon.</p>

</div>
@stop