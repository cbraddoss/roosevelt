@extends('admin.users')

@section('admin-user-content')

<div class="create-something-new-bg"></div>
<div id="admin-new-user-form" class="create-something-new">
	<span class="admin-button"><button class="add-new">Add New</button></span>
</div>

<h3>Admin Users</h3>
@foreach($users as $u)
	@if($u->userrole == 'admin')
	<p class="admin-p">
		<a href="/admin/users/{{ any_user_path($u->id) }}" class="admin-link userrole-{{ $u->userrole }} status-{{ $u->status }}">
			<img src="{{ gravatar_url($u->email,50) }}" alt="{{ $u->first_name }} {{ $u->last_name }}">
			{{ $u->first_name }}<br/>{{ $u->last_name }}
		</a>
		<small class="last-login">{{ user_last_login($u->last_login) }}</small>
	</p>
	@endif
@endforeach
<br class="clear">

<h3>Standard Users</h3>
@foreach($users as $u)
	@if($u->userrole == 'standard' && $u->status == 'active')
	<p class="admin-p">
		<a href="/admin/users/{{ any_user_path($u->id) }}" class="admin-link userrole-{{ $u->userrole }} status-{{ $u->status }}">
			<img src="{{ gravatar_url($u->email,50) }}" alt="{{ $u->first_name }} {{ $u->last_name }}">
			{{ $u->first_name }}<br/>{{ $u->last_name }}
		</a>
		<small class="last-login">{{ user_last_login($u->last_login) }}</small>
	</p>
	@endif
@endforeach

<br class="clear">

<h3>Inactive Users</h3>
@foreach($users as $u)
	@if($u->status == 'inactive')
	<p class="admin-p">
		<a href="/admin/users/{{ any_user_path($u->id) }}" class="admin-link userrole-{{ $u->userrole }} status-{{ $u->status }}">
			<img src="{{ gravatar_url($u->email,50) }}" alt="{{ $u->first_name }} {{ $u->last_name }}">
			{{ $u->first_name }}<br/>{{ $u->last_name }}
		</a>
		<small class="last-login">{{ user_last_login($u->last_login) }}</small>
	</p>
	@endif
@endforeach

<span class="admin-span"><a></a></span>

@stop