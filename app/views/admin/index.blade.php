@extends('layout.main')

@section('page-h1')
{{ 'Admin' }}
@stop

@section('page-h2')
{{ 'Admin' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('profile.partials.profile-menu')
	</ul>
</div>
@stop

@section('page-content')
<div id="admin-page"  class="inner-page">
	<h2>Admin With Care:</h2>

	<div class="link-box-wrapper">
		<div class="link-box"><a href="/admin/templates" class="admin-link ss-layout">Templates</a></div>
		<div class="link-box"><a href="/admin/users" class="admin-link ss-users">Users</a></div>
	</div>

</div>
@stop