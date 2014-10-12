@extends('layout.main')

@section('page-h1')
{{ 'Tools' }}
@stop

@section('page-h2')
{{ 'Tools and Links for InsideOut Employees' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li><a id="pagelink-tools" href="/tools/" class="link">Tools</a></li>
		<li><a id="pagelink-tools-status" href="/tools/status" class="link">Status</a></li>
	</ul>
</div>
@stop

@section('page-content')
<div id="tools-page"  class="inner-page">
	<h2>@yield('page-h2')</h2>

	<div class="link-box"><a href="#" target="_blank">1Password</a></div>

	<div class="link-box"><a href="http://status.apps.rackspace.com/" target="_blank">Rackspace Email/Apps Status</a></div>
	<div class="link-box"><a href="https://status.rackspace.com/" target="_blank">Rackspace Servers Status</a></div>

	<div class="link-box"><a href="https://dropbox.com" target="_blank">Dropbox: InsideOut Fileshare</a></div>
	<div class="link-box"><a href="http://my.onsip.com" target="_blank">Voicemail</a></div>
	<div class="link-box"><a href="http://webmail.insideout.com/" target="_blank">Webmail</a></div>
	<div class="link-box"><a href="http://login.insideout.com/admin/" target="_blank">Client WebTools</a></div>
	<div class="link-box"><a href="#" target="_blank">Plugin Repo</a></div>
	<div class="link-box"><a href="#" target="_blank">WordPress Version Checker</a></div>
	<div class="link-box"><a href="#" target="_blank">Hosted Sites</a></div>
</div>
@stop