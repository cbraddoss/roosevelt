@extends('layout.main')

@section('page-title')
{{ 'Admin' }}
@stop

@section('page-content')
<div id="admin-page"  class="inner-page">
	<div id="user-management">
		
		<h3>User Management</h3>
		
		<table id="users-table">
			
			<tr class="table-title">
				<th class="title-name">Name</th>
				<th class="title-email">Email</th>
				<th class="title-password">Password</th>
				<th class="title-userrole">User Role</th>
				<th class="title-extension">Extension</th>
				<th class="title-cell-phone">Cell Phone</th>
				<th class="title-status">Status</th>
				<th class="title-edit">Edit</th>
			</tr>
			
			@include('admin.partials.user-list')

			<tr>
				<td class="button-add-new"><button class="add-new">Add New User</button></td>
			</tr>

			<tr id="user-new" class="user-form">
				@include('admin.partials.user-add-new')
			</tr>

		</table>

	</div>

	<div id="template-management">
		<h3>Template Management</h3>
		<p>...</p>
	</div>

</div>
@stop

@section('page-js')
<script type="text/javascript">
jQuery(document).ready(function($){
	// Listen for ajax events and update page (still in development)	
	setInterval(function(){
		var elementsActive = $('.user-list').length;
		$.get( "/admin/check", function( data ) {
			var elementsLoaded = $(data).filter('tr.user-list').length;
			if(elementsLoaded>elementsActive) {
			var findLastLoaded = $(data).filter('tr.user-list').last();
			$( findLastLoaded ).insertAfter( "tr.user-list:last" ).css('background','rgba(75,131,180,0.2)');
			}
		});
	}, 10000);
});
</script>
@stop