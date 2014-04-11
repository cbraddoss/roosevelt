@extends('layout.main')

@section('page-title')
{{ 'Admin' }}
@stop

@section('page-content')
<div id="admin-page"  class="inner-page">
	
	<p class="admin-p"><a href="/admin/users" class="admin-link ss-users">Users</a></p>
	<p class="admin-p"><a href="/admin/templates" class="admin-link ss-layout">Templates</a></p>

	<span class="admin-span"><a></a></span>
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