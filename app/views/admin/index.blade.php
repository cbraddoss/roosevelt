@extends('layout.main')

@section('page-title')
{{ 'Admin' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li><a id="pagelink-admin" href="/admin/" class="link">Admin</a></li>
		<li><a id="pagelink-admin-templates" href="/admin/templates" class="link">Templates</a></li>
		<li><a id="pagelink-admin-users" href="/admin/users" class="link">Users</a></li>
		<li>
			<div id="admin-new-template-form" class="create-something-new">
				<div class="template-button"><span class="add-new add-button"><span class="ss-plus"></span> Template</span></div>
			</div>
		</li>
		<li>
			<div id="admin-new-user-form" class="create-something-new">
				<div class="admin-button"><span class="add-new add-button"><span class="ss-plus"></span> User</span></div>
			</div>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="admin-page"  class="inner-page">

	<div class="link-box-wrapper">
		<h2>Admin With Care:</h2>
		<div class="link-box"><a href="/admin/templates" class="admin-link ss-layout">Templates</a></div>
		<div class="link-box"><a href="/admin/users" class="admin-link ss-users">Users</a></div>
	</div>

</div>
@stop