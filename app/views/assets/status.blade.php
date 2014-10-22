@extends('layout.main')

@section('page-h1')
{{ 'Status' }}
@stop

@section('page-h2')
{{ 'Site and Server Status:' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('assets.partials.assets-menu')
	</ul>
</div>
@stop

@section('page-content')
<div id="assets-page"  class="inner-page">
	<h2>@yield('page-h2')</h2>
	
	<p class="ss-link"><a href="http://status.apps.rackspace.com/" target="_blank">Rackspace Email/Apps Status</a></p>
	<p class="ss-link"><a href="https://status.rackspace.com/" target="_blank">Rackspace Servers Status</a></p>

	<div class="StatusCake"></div><link rel="stylesheet" media="all" href="https://www.statuscake.com/App/Widget/table.css"/><script type="text/javascript">var PublicID = 'BapGe180zF'; var ShowAd = true; var Status = document.createElement('script'); Status.src = 'https://www.statuscake.com/App/Widget/Widget2JS.js'; Status.type = 'text/javascript'; Status.async = true; var ssc = document.getElementsByTagName('script')[0]; ssc.parentNode.insertBefore(Status, ssc);</script>

</div>
@stop