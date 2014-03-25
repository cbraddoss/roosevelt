@extends('layout.main')

@section('page-content')
<div id="page-title">
	<h2>Admin</h2>
</div>
<div id="admin-page"  class="inner-page">
	<div id="user-management">
		<h3>User Management</h3>
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
				<td class="user-name">{{ $u->first_name }} {{ $u->last_name }}</td>
				<td class="user-email">{{ $u->email }}</td>
				<td class="user-password">********</td>
				<td class="user-userrole">{{ $u->userrole }}</td>
				<td class="user-extension">{{ $u->extension }}</td>
				<td class="user-cell-phone">{{ $u->cell_phone }}</td>
				<td class="user-status">@if( $u->status == "active") <span class="ss-check"></span> @else <span class="ss-delete"></span> @endif</td>
				<td class="user-edit"><button id="{{ $u->id }}" class="edit ss-write"></button></td>
			</tr>
			
			<tr id="user-{{ $u->id }}" class="user-form">
				<td colspan="8">
					<div class="user-update-form">
					
					{{ Form::open( array('id' => $u->id, 'url' => 'admin', 'method' => 'post') ) }}
					
					{{ Form::hidden('id',$u->id) }}
					
					{{ Form::text('first_name', $u->first_name, array('placeholder' => 'First Name', 'class' => 'first-name field', 'autofocus' => 'autofocus')) }}
					
					{{ Form::text('last_name', $u->last_name, array('placeholder' => 'Last Name', 'class' => 'last-name field')) }}
					
					{{ Form::email('email', $u->email, array('placeholder' => 'Email Address', 'class' => 'email field')) }}
					
					{{ Form::password('password', array('placeholder' => 'Password', 'class' => 'password field')) }}
					
					{{ Form::select('userrole', array('admin' => 'admin', 'standard' => 'standard') , $u->userrole) }}
					<span class="select-label"></span>
					{{ Form::text('extension', $u->extension, array('placeholder' => 'Extension', 'class' => 'extension field')) }}
					
					{{ Form::text('cell_phone', $u->cell_phone, array('placeholder' => 'Cell Phone', 'class' => 'cell-phone field')) }}
					
					{{ Form::select('status', array('active' => 'active', 'inactive' => 'inactive'), $u->status ) }}
					<span class="select-label"></span>
					{{ Form::submit('Save User', array('class' => 'save', 'id' => $u->id) ) }}
					
					<button id="{{ $u->id }}" class="cancel">Cancel</button>

					{{ Form::close() }}
					
					{{ Form::open( array('id' => 'delete-'.$u->id, 'url' => 'admin', 'method' => 'post') ) }}
					
					{{ Form::submit('Delete User', array('class' => 'delete', 'id' => $u->id) ) }}

					{{ Form::close() }}
					</div>
				</td>
			</tr>
		@endforeach
		</table>
		<button class="add-new">Add New User</button>
	</div>
	<div id="template-management">
		<h3>Template Management</h3>
		<p>...</p>
	</div>
</div>
@stop