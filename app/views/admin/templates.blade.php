@extends('layout.main')

@section('page-title')
{{ 'Admin - Template Management' }}
@stop

@section('page-content')
<div id="admin-page"  class="inner-page">
	<div class="page-menu">
		<ul>
			<li><a href="/admin/" class="link">Admin</a></li>
			<li><a href="/admin/users" class="link">User Management</a></li>
			<li><a href="/admin/templates" class="link">Template Management</a></li>
		</ul>
		<div id="admin-new-template-form" class="create-something-new">
			<span class="admin-button"><button class="add-new">Add New</button></span>
		</div>
	</div>

	<p>Manage Project, Task, Billable, and Help templates here...</p>

</div>
@stop