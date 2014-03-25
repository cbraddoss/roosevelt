@extends('layout.main')

@section('page-content')
<div id="page-title">
	<h2>Admin</h2>
</div>
<div id="admin-page"  class="inner-page">
	<div id="user-management">
		<div class="user-updated"><p></p></div>
		<div class="user-deleted"><p></p></div>
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
				<td class="user-edit">
					<button id="{{ $u->id }}" class="edit ss-write"></button>
				</td>
			</tr>
			
			<tr id="user-{{ $u->id }}" class="user-form">
				<td colspan="8">
					<div class="user-update-form">
					
					{{ Form::open( array('id' => $u->id, 'class' => 'update-user', 'url' => 'admin', 'method' => 'post') ) }}
					
					{{ Form::hidden('id',$u->id) }}

					{{ Form::hidden('confirm-update', 'yes') }}
					
					{{ Form::text('first_name', $u->first_name, array('placeholder' => 'First Name', 'class' => 'first-name field', 'autofocus' => 'autofocus')) }}
					
					{{ Form::text('last_name', $u->last_name, array('placeholder' => 'Last Name', 'class' => 'last-name field')) }}
					
					{{ Form::email('email', $u->email, array('placeholder' => 'Email Address', 'class' => 'email field')) }}
					
					{{ Form::password('password', array('placeholder' => 'Password', 'class' => 'password field')) }}
					
					{{ Form::select('userrole', array('admin' => 'admin', 'standard' => 'standard') , $u->userrole) }}
					
					{{ Form::text('extension', $u->extension, array('placeholder' => 'Extension', 'class' => 'extension field')) }}
					
					{{ Form::text('cell_phone', $u->cell_phone, array('placeholder' => 'Cell Phone', 'class' => 'cell-phone field')) }}
					
					{{ Form::select('status', array('active' => 'active', 'inactive' => 'inactive'), $u->status ) }}
					
					{{ Form::submit('Save User', array('class' => 'save', 'id' => $u->id) ) }}
					
					{{ Form::close() }}

					<button id="{{ $u->id }}" class="cancel">Hide</button>

					{{ Form::open( array('id' => $u->id, 'class' => 'delete-user', 'url' => 'admin', 'method' => 'post') ) }}
					
					{{ Form::hidden('id', $u->id) }}

					{{ Form::hidden('confirm-delete', 'yes') }}

					{{ Form::hidden('first_name', $u->first_name) }}
					
					{{ Form::hidden('last_name', $u->last_name) }}

					{{ Form::submit('Delete User', array('class' => 'delete', 'id' => $u->id) ) }}

					{{ Form::close() }}
					</div>
				</td>
			</tr>
		@endforeach
			<tr>
				<td class="button-add-new"><button class="add-new">Add New User</button></td>
			</tr>
			<tr id="user-new" class="user-form">
				<td colspan="8">

					<div class="user-add-form">
					
					{{ Form::open( array('id' => 'add-new', 'class' => 'add-user', 'url' => 'admin', 'method' => 'post') ) }}
					
					{{ Form::hidden('confirm-add', 'yes') }}
					
					{{ Form::text('first_name', null, array('placeholder' => 'First Name', 'class' => 'first-name field', 'autofocus' => 'autofocus')) }}
					
					{{ Form::text('last_name', null, array('placeholder' => 'Last Name', 'class' => 'last-name field')) }}
					
					{{ Form::email('email', null, array('placeholder' => 'Email Address', 'class' => 'email field')) }}
					
					{{ Form::password('password', array('placeholder' => 'Password', 'class' => 'password field')) }}
					
					{{ Form::select('userrole', array('admin' => 'admin', 'standard' => 'standard') , 'standard') }}
					
					{{ Form::text('extension', null, array('placeholder' => 'Extension', 'class' => 'extension field')) }}
					
					{{ Form::text('cell_phone', null, array('placeholder' => 'Cell Phone', 'class' => 'cell-phone field')) }}
					
					{{ Form::select('status', array('active' => 'active', 'inactive' => 'inactive'), 'active' ) }}
					
					{{ Form::submit('Add User', array('class' => 'save', 'id' => 'add-new-submit') ) }}
					
					{{ Form::close() }}

					<button id="add-new" class="cancel">Cancel</button>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div id="template-management">
		<h3>Template Management</h3>
		<p>...</p>
	</div>
</div>
@stop