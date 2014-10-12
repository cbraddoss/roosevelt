@extends('layout.main')

@section('page-h1')
{{ 'Admin' }}
@stop

@section('page-h2')
{{ 'User Management' }}
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
		
	@yield('admin-user-content')

</div>
@stop