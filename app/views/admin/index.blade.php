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
				<th>Name</th><th>Email</th><th>Username</th><th>Password</th><th>User Role</th><th>Extension</th><th>Cell Phone</th><th>Status</th><th>Edit</th>
			</tr>
		@foreach($users as $u)
			<tr class="user-list user-list-{{ $u->id }}">
				<td>{{ $u->first_name }} {{ $u->last_name }}</td>
				<td>{{ $u->email }}</td>
				<td>{{ $u->username }}</td>
				<td>********</td>
				<td>{{ $u->userrole }}</td>
				<td>{{ $u->extension }}</td>
				<td>{{ $u->cell_phone }}</td>
				<td>@if( $u->active == 1) <span class="ss-check"></span> @else <span class="ss-delete"></span> @endif</td>
				<td><button id="{{ $u->id }}" class="edit">Edit</button></td>
			</tr>
			
			<tr id="user-{{ $u->id }}" class="user-form">
				<td colspan="9">
					<div class="user-update-form">
					<h4>Edit: {{ $u->first_name }} {{ $u->last_name }}</h4>
					{{ Form::open( array('id' => '$u->id') ) }}
					<div class="left">
					{{ Form::hidden('id',$u->id) }}
					{{ Form::label('first_name','First Name:') }}
					{{ Form::text('first_name', $u->first_name, array('placeholder' => 'First Name', 'class' => 'field', 'autofocus' => 'autofocus')) }}
					{{ Form::label('last_name','Last Name:') }}
					{{ Form::text('last_name', $u->last_name, array('placeholder' => 'Last Name', 'class' => 'field')) }}
					{{ Form::label('email','Email:') }}
					{{ Form::email('email', $u->email, array('placeholder' => 'Email Address', 'class' => 'field')) }}
					</div>
					{{ Form::label('username','Username:') }}
					{{ Form::text('username', $u->username, array('placeholder' => 'Username', 'class' => 'field')) }}
					{{ Form::label('password','Password:') }}
					{{ Form::password('password', null, array('placeholder' => 'Password', 'class' => 'field')) }}
					{{ Form::label('userrole','User Role:') }}
					{{ Form::text('userrole', $u->userrole, array('placeholder' => 'User Role', 'class' => 'field')) }}
					{{ Form::label('extension','Extension:') }}
					{{ Form::text('extension', $u->extension, array('placeholder' => 'Extension', 'class' => 'field')) }}
					{{ Form::label('cell_phone','Cell:') }}
					{{ Form::text('cell_phone', $u->cell_phone, array('placeholder' => 'Cell Phone', 'class' => 'field')) }}
					{{ Form::label('active','Status:') }}
					{{ Form::checkbox('active', $u->active ) }}
					{{ Form::close() }}
					<button id="{{ $u->id }}" class="cancel">Cancel</button>
					<button id="{{ $u->id }}" class="delete">Delete</button>
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