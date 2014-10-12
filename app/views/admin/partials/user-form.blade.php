@extends('admin.users')

@section('page-h2')
{{ 'User: ' . $user->first_name . ' ' . $user->last_name }}
@stop

@section('admin-user-content')
<div class="update-something-form">
{{ Form::open( array('class' => 'update-user', 'url' => '/admin/users/'.$user->user_path, 'method' => 'post', 'id' => $user->id) ) }}

{{ Form::hidden('id', $user->id) }}

<div class="new-form-field">
	{{ Form::label('first_name','First Name:') }}
	{{ Form::text('first_name', $user->first_name, array('placeholder' => 'First Name', 'class' => 'first-name field')) }}
</div>

<div class="new-form-field">
	{{ Form::label('last_name','Last Name:') }}
	{{ Form::text('last_name', $user->last_name, array('placeholder' => 'Last Name', 'class' => 'last-name field')) }}
</div>

<div class="new-form-field">
	{{ Form::label('email','Email:') }}
	{{ Form::text('email', $user->email, array('placeholder' => 'Email', 'class' => 'email field')) }}
</div>

<div class="new-form-field">
	{{ Form::label('anniversary','Anniversary:') }}
	@if($user->anniversary == '0000-00-00 00:00:00') {{ Form::text('anniversary', null, array('placeholder' => Carbon::now()->format('m/d/Y'), 'class' => 'datepicker anniversary field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}
	@else {{ Form::text('anniversary', Carbon::createFromFormat('Y-m-d H:i:s', $user->anniversary)->format('m/d/Y'), array('placeholder' => Carbon::now()->format('m/d/Y'), 'class' => 'datepicker anniversary field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}
	@endif
</div>

<div class="new-form-field">
	{{ Form::label('extension','Extension:') }}
	{{ Form::text('extension', $user->extension, array('placeholder' => '555', 'class' => 'extension field')) }}
</div>

<div class="new-form-field">
	{{ Form::label('cell_phone','Cell Phone:') }}
	{{ Form::text('cell_phone', $user->cell_phone, array('placeholder' => '555-555-5555', 'class' => 'cell-phone field', 'autocomplete' => 'off')) }}
</div>

<div class="new-form-field">
	{{ Form::label('userrole','User Role:') }}
	<div class="select-dropdown">
		<span class="ss-dropdown"></span>
		<span class="ss-directup"></span>
		{{ Form::select('userrole', array('admin' => 'Admin', 'standard' => 'Standard', 'non-standard' => 'Sub-contracted'), $user->userrole) }}
	</div>
</div>

<div class="new-form-field">
	{{ Form::label('can_manage','Can Manage:') }}
	<div class="select-dropdown">
		<span class="ss-dropdown"></span>
		<span class="ss-directup"></span>
		{{ Form::select('can_manage', array('no' => 'No', 'yes' => 'Yes'), $user->can_manage) }}
	</div>
</div>

<div class="new-form-field">
	{{ Form::label('status','User Status:') }}
	<div class="select-dropdown">
		<span class="ss-dropdown"></span>
		<span class="ss-directup"></span>
		{{ Form::select('status', array('active' => 'Active', 'inactive' => 'Inactive'), $user->status ) }}
	</div>
</div>

<div class="new-form-field">
	{{ Form::label('password','New Password:') }}
	{{ Form::password('password', array('placeholder' => 'New Password', 'class' => 'password field')) }}
</div>

<div class="new-form-field">
	{{ Form::label('password_again','New Password Again:') }}
	{{ Form::password('password_again', array('placeholder' => 'New Password Again', 'class' => 'password_again field')) }}
</div>

	{{ Form::submit('Save User', array('class' => 'save-user form-button') ) }}

	<a href="/admin/users" class="form-button cancel">Cancel</a>

{{ Form::close() }}

{{ Form::open( array('class' => 'delete-user delete-post', 'url' => '/admin/users', 'method' => 'delete') ) }}
{{ Form::hidden('id', $user->id) }}
{{ Form::hidden('first_name', $user->first_name, array('class' => 'first-name field')) }}
{{ Form::hidden('last_name', $user->last_name, array('class' => 'last-name field')) }}
{{ Form::submit('Delete User', array('class' => 'delete form-button') ) }}
{{ Form::close() }}
</div>
@stop