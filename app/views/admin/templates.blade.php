@extends('layout.main')

@section('page-title')
{{ 'Admin - Template Management' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li>
		@if(strpos(current_page(), 'edit'))
		<div id="admin-preview-template-form" class="create-something-new">
			<span class="template-button"><button class="preview-template ss-view">Preview</button></span>
		</div>
		@else
		<div id="admin-new-template-form" class="create-something-new">
			<span class="template-button"><button class="add-new ss-plus">Add New</button></span>
		</div>
		@endif
		</li>
		<li><a href="/admin/" class="link">Admin</a></li>
		<li><a href="/admin/users" class="link">Users</a></li>
		<li><a href="/admin/templates" class="link">Templates</a></li>
	</ul>
</div>
@stop

@section('page-content')
<div id="admin-page"  class="inner-page">

	@yield('admin-template-content')

</div>
@stop