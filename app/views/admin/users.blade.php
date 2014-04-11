@extends('layout.main')

@section('page-title')
{{ 'Admin - User Management' }}
@stop

@section('page-content')
<div id="admin-page"  class="inner-page">
		
	@yield('admin-user-content')

</div>
@stop