@extends('admin.users')

@section('page-title')
{{ 'User: ' . $user->first_name . ' ' . $user->last_name }}
@stop

@section('admin-user-content')
	
{{ Form::open( array('class' => 'update-user', 'url' => '/admin/users/'.$user->user_path, 'method' => 'post', 'id' => $user->id) ) }}

{{ Form::hidden('id', $user->id) }}

<div class="user-field">
	<span class="user-title first-name">{{ Form::label('first_name','First Name:') }}</span>
	<span class="user-value first-name-value">{{ Form::text('first_name', $user->first_name, array('placeholder' => 'First Name', 'class' => 'first-name field')) }}</span>
</div>
<div class="user-field">
	<span class="user-title last-name">{{ Form::label('last_name','Last Name:') }}</span>
	<span class="user-value last-name-value">{{ Form::text('last_name', $user->last_name, array('placeholder' => 'Last Name', 'class' => 'last-name field')) }}</span>
</div>
<div class="user-field">
	<span class="user-title email">{{ Form::label('email','Email:') }}</span>
	<span class="user-value email-value">{{ Form::text('email', $user->email, array('placeholder' => 'Email', 'class' => 'email field')) }}</span>
</div>
<div class="user-field">
	<span class="user-title anniversary">{{ Form::label('anniversary','Anniversary:') }}</span>
	@if($user->anniversary == '0000-00-00 00:00:00') <span class="user-value anniversary-value">{{ Form::text('anniversary', null, array('placeholder' => Carbon::now()->format('m/d/Y'), 'class' => 'datepicker anniversary field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}</span>
	@else <span class="user-value anniversary-value">{{ Form::text('anniversary', Carbon::createFromFormat('Y-m-d H:i:s', $user->anniversary)->format('m/d/Y'), array('placeholder' => Carbon::now()->format('m/d/Y'), 'class' => 'datepicker anniversary field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}</span>
	@endif
</div>
<div class="user-field">
	<span class="user-title extension">{{ Form::label('extension','Extension:') }}</span>
	<span class="user-value extension-value">{{ Form::text('extension', $user->extension, array('placeholder' => '555', 'class' => 'extension field')) }}</span>
</div>
<div class="user-field">
	<span class="user-title cell-phone">{{ Form::label('cell_phone','Cell Phone:') }}</span>
	<span class="user-value cell-phone-value">{{ Form::text('cell_phone', $user->cell_phone, array('placeholder' => '555-555-5555', 'class' => 'cell-phone field')) }}</span>
</div>
<div class="user-field">
	<span class="user-title userrole">{{ Form::label('userrole','User Role:') }}</span>
	<span class="user-value userrole-value select-dropdown">
		<span class="ss-dropdown"></span>
		<span class="ss-directup"></span>
		{{ Form::select('userrole', array('admin' => 'Admin', 'standard' => 'Standard'), $user->userrole) }}
	</span>
</div>
<div class="user-field">
	<span class="user-title can-manage">{{ Form::label('can_manage','Can Manage:') }}</span>
	<span class="user-value can-manage-value select-dropdown">
		<span class="ss-dropdown"></span>
		<span class="ss-directup"></span>
		{{ Form::select('can_manage', array('no' => 'No', 'yes' => 'Yes'), $user->can_manage) }}
	</span>
</div>
<div class="user-field">
	<span class="user-title status">{{ Form::label('status','User Status:') }}</span>
	<span class="user-value status-value select-dropdown">
		<span class="ss-dropdown"></span>
		<span class="ss-directup"></span>
		{{ Form::select('status', array('active' => 'Active', 'inactive' => 'Inactive'), $user->status ) }}
	</span>
</div>
<div class="user-field">
	<span class="user-title password">{{ Form::label('password','New Password:') }}</span>
	<span class="user-value password-value">{{ Form::password('password', array('placeholder' => 'New Password', 'class' => 'password field')) }}</span>
</div>
<div class="user-field">
	<span class="user-title password">{{ Form::label('password_again','New Password Again:') }}</span>
	<span class="user-value password-value">{{ Form::password('password_again', array('placeholder' => 'New Password Again', 'class' => 'password_again field')) }}</span>
</div>
<div class="user-field">
	{{ Form::submit('Save User', array('class' => 'save-user') ) }}
</div>
<div class="user-field">
	<a href="/admin/users" class="button cancel">Cancel</a>
</div>


{{ Form::close() }}


{{ Form::open( array('class' => 'delete-user', 'url' => '/admin/users', 'method' => 'delete') ) }}

{{ Form::hidden('id', $user->id) }}

{{ Form::hidden('first_name', $user->first_name, array('class' => 'first-name field')) }}

{{ Form::hidden('last_name', $user->last_name, array('class' => 'last-name field')) }}
<div class="user-field">
{{ Form::submit('Delete User', array('class' => 'delete') ) }}
</div>
{{ Form::close() }}

@stop