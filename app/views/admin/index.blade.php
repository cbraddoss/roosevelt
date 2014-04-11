@extends('layout.main')

@section('page-title')
{{ 'Admin' }}
@stop

@section('page-content')
<div id="admin-page"  class="inner-page">
	
	<p class="admin-p"><a href="/admin/users" class="admin-link ss-users">Users</a></p>
	<p class="admin-p"><a href="/admin/templates" class="admin-link ss-layout">Templates</a></p>

	<span class="admin-span"><a></a></span>
</div>
@stop