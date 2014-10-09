@extends('layout.main')

@section('page-title')
{{ 'Invoices' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<ul>
			<li><a id="pagelink-invoices-open" href="/invoices/status/open" class="link">Open</a></li>
			<li>
				<div id="invoices-new-invoice-form" class="create-something-new">
					<div class="invoices-button"><span class="add-new add-button"><span class="ss-plus"></span> Invoice</span></div>
				</div>
			</li>
		</ul>
	</ul>
</div>
@stop

@section('page-content')
<div id="invoices-page"  class="inner-page">

	<h2>Internet gremlins are still assembling this page.</h2>
	<p>Check back soon.</p>

</div>
@stop