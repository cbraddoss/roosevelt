@extends('layout.main')

@section('page-title')
{{ 'Billables' }}
@stop

@section('header-menu')
	<div class="page-menu">
		<ul>
			<li><a id="pagelink-billables-open" href="/billables/status/open" class="link">Open</a></li>
			<li>
				<div id="billables-new-billable-form" class="create-something-new">
					<div class="billables-button"><span class="add-new add-button"><span class="ss-plus"></span> Billable</span></div>
				</div>
			</li>
		</ul>
	</div>
@stop

@section('page-content')
<div id="billables-page"  class="inner-page">
	
	<h2>Internet gremlins are still assembling this page.</h2>
	<p>Check back soon.</p>

</div>
@stop