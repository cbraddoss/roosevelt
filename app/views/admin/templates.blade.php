@extends('layout.main')

@section('page-title')
{{ 'Admin - Template Management' }}
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

	@yield('admin-template-content')

</div>
@stop