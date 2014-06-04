@extends('layout.main')

@section('page-title')
{{ 'Admin' }}
@stop

@section('page-content')
<div id="admin-page"  class="inner-page">
	<div class="page-menu">
		<ul>
			<li><a href="/admin/" class="link">Admin</a></li>
			<li><a href="/admin/users" class="link">Users</a></li>
			<li><a href="/admin/templates" class="link">Templates</a></li>
		</ul>
	</div>

	<p class="admin-p"><a href="/admin/users" class="admin-link ss-users">Users</a></p>
	<p class="admin-p"><a href="/admin/templates" class="admin-link ss-layout">Templates</a></p>

	<span class="admin-span"><a></a></span>
</div>
@stop