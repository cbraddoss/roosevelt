@extends('layout.main')

@section('page-title')
{{ 'Tools' }}
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
	<h2>Miscellaneous Tools and Links for InsideOut Employees</h2>

	<p><a href="#" target="_blank">1Password</a></p>

	<p><a href="http://status.apps.rackspace.com/" target="_blank">Rackspace Apps Status</a> <small>(includes Email server status)</small></p>
	<p><a href="https://status.rackspace.com/" target="_blank">Rackspace Servers Status</a></p>

	<p><a href="https://dropbox.com" target="_blank">Dropbox: InsideOut Fileshare</a> <small>(requires username and password)</small></p>
	<p><a href="http://my.onsip.com" target="_blank">Voicemail</a> <small>(requires username and password)</small></p>
	<p><a href="http://webmail.insideout.com/" target="_blank">Webmail</a> <small>(requires username and password)</small></p>
	<p><a href="http://login.insideout.com/admin/" target="_blank">Client WebTools</a> <small>(requires username and password)</small></p>
	<p><a href="#" target="_blank">Plugin Repo</a></p>
	<p><a href="#" target="_blank">WordPress Version Checker</a></p>
	<p><a href="#" target="_blank">Hosted Sites</a></p>
</div>
@stop