@extends('layout.main')

@section('page-h1')
{{ 'Invoices' }}
@stop

@section('page-h2')
{{ 'Open Invoices' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<ul>
			<li><a id="pagelink-invoices" href="/invoices" class="link">Open</a></li>
			<li class="right">
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
	<h2>@yield('page-h2')</h2>

	<h3>Internet gremlins are still assembling this page.</h3>
	<p>Check back soon.</p>

</div>
@stop