@extends('layout.main')

@section('page-h1')
{{ 'Assets' }}
@stop

@section('page-h2')
{{ 'Employee Assets and Resources:' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('assets.partials.assets-menu')
		<li class="right">
			<div id="assets-new-asset-form" class="create-something-new">
				<div class="assets-button"><span class="add-new add-button"><span class="ss-plus"></span> Add New</span></div>
			</div>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="assets-page"  class="inner-page">
	<h2>@yield('page-h2')</h2>

	<div class="link-box"><a class="ss-dropbox ss-social" href="https://dropbox.com" target="_blank">Dropbox</a></div>
	<div class="link-box"><a class="ss-phone" href="http://my.onsip.com" target="_blank">Voicemail</a></div>
	<div class="link-box"><a class="ss-mail" href="http://webmail.insideout.com/" target="_blank">Webmail</a></div>
	<div class="link-box"><a class="ss-layout" href="http://login.insideout.com/admin/" target="_blank">Client WebTools</a></div>
	<!-- <div class="link-box"><a class="ss-phone" href="#" target="_blank">Plugin Repo</a></div> -->
	<div class="link-box"><a class="ss-globe" href="#" target="_blank">Hosted Sites</a></div>
</div>
@stop