@extends('layout.main')

@section('page-content')
<div id="page-title">
	<h2>Admin</h2>
</div>

<div id="admin-page"  class="inner-page">
	<div id="user-management">
		
		<h3>User Management</h3>
		<!-- <div id="users-list-title">
			<ul>
				<li class="title-name">Name</li>
				<li class="title-email">Email</li>
				<li class="title-password">Password</li>
				<li class="title-userrole">User Role</li>
				<li class="title-extension">Extension</li>
				<li class="title-cell-phone">Cell Phone</li>
				<li class="title-status">Status</li>
				<li class="title-edit">Edit</li>
			</ul>
		</div> -->
		<table id="users-table">
			
			<tr>
				<th class="title-name">Name</th>
				<th class="title-email">Email</th>
				<th class="title-password">Password</th>
				<th class="title-userrole">User Role</th>
				<th class="title-extension">Extension</th>
				<th class="title-cell-phone">Cell Phone</th>
				<th class="title-status">Status</th>
				<th class="title-edit">Edit</th>
			</tr>
			
			@foreach($users as $u)
			<tr class="user-list user-list-{{ $u->id }}">
				@include('admin.partials.user-list')
			</tr>
			@endforeach

			<tr>
				<td class="button-add-new"><button class="add-new">Add New User</button></td>
			</tr>

			<tr id="user-new" class="user-form">
				@include('admin.partials.user-add-new')
			</tr>

		</table>

	</div>

	<div id="template-management">
		<h3>Template Management</h3>
		<p>...</p>
	</div>

</div>

@stop