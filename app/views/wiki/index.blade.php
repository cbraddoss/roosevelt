@extends('layout.main')

@section('page-title')
{{ 'Wiki' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li><a id="pagelink-wiki-security" href="/wiki/security" class="link">Security</a></li>
		<li class="right">
			<div id="wiki-new-wiki-form" class="create-something-new">
				<div class="wiki-button"><span class="add-new add-button"><span class="ss-plus"></span> Wiki Post</span></div>
			</div>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="wiki-page"  class="inner-page">
	
	<h2>Internet gremlins are still assembling this page.</h2>
	<p>Check back soon.</p>
</div>
@stop