@extends('layout.main')

@section('page-title')
{{ 'Admin - User Management' }}
@stop

@section('header-menu')

<div class="page-menu">
	<ul>
		@if(current_page() == '/admin/users')
		<li>
			<div id="admin-new-user-form" class="create-something-new">
				<span class="admin-button"><button class="add-new ss-plus">Add New</button></span>
			</div>
		</li>
		@endif
		<li><a href="/admin/" class="link">Admin</a></li>
		<li><a href="/admin/users" class="link">Users</a></li>
		<li><a href="/admin/templates" class="link">Templates</a></li>
	</ul>
</div>
@stop

@section('page-content')
<div id="admin-page"  class="inner-page">
		
	@yield('admin-user-content')

</div>
@stop