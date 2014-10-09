@extends('admin.users')

@section('admin-user-content')
<h2>Admin Users</h2>
@foreach($users as $u)
	@if($u->userrole == 'admin')
	<div id="user-{{ $u->id }}" class="office-post user-list user-list-admins">
		@include('admin.partials.user-list-details')
	</div>
	@endif
@endforeach

<h2>Standard Users</h2>
@foreach($users as $u)
	@if($u->userrole == 'standard' && $u->status == 'active')
	<div id="user-{{ $u->id }}" class="office-post user-list user-list-standard">
		@include('admin.partials.user-list-details')
	</div>
	@endif
@endforeach

<h2>Sub-contracted (non-standard) Users</h2>
@foreach($users as $u)
	@if($u->userrole == 'non-standard' && $u->status == 'active')
	<div id="user-{{ $u->id }}" class="office-post user-list user-list-non-standard">
		@include('admin.partials.user-list-details')
	</div>
	@endif
@endforeach

<h2>Inactive Users</h2>
@foreach($users as $u)
	@if($u->status == 'inactive')
	<div id="user-{{ $u->id }}" class="office-post user-list user-list-inactive">
		@include('admin.partials.user-list-details')
	</div>
	@endif
@endforeach

@stop