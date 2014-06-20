@extends('layout.main')

@section('page-title')
{{ 'Admin' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li>
			<div id="admin-new-template-form" class="create-something-new">
				<span class="template-button"><button class="add-new ss-plus">Template</button></span>
			</div>
		</li>
		<li>
			<div id="admin-new-user-form" class="create-something-new">
				<span class="admin-button"><button class="add-new ss-plus">User</button></span>
			</div>
		</li>
		<li><a href="/admin/" class="link">Admin</a></li>
		<li><a href="/admin/users" class="link">Users</a></li>
		<li><a href="/admin/templates" class="link">Templates</a></li>
	</ul>
</div>
@stop

@section('page-content')
<div id="admin-page"  class="inner-page">

	<p class="admin-p"><a href="/admin/users" class="admin-link ss-users">Users</a></p>
	<p class="admin-p"><a href="/admin/templates" class="admin-link ss-layout">Templates</a></p>

	<span class="admin-span"><a></a></span>
</div>
@stop