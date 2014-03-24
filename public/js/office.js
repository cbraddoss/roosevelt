jQuery(document).ready(function($){
	//var pageHeight = $(window).height()-150;
	//$('#page').css('height', pageHeight);
	$('#projects-feed').hide();
	$('#leads-feed').hide();

	//Show/hide task items in sidebar
	$('#show-tasks-list').click(function() {
		$('#tasks-feed').toggle();
	});
	$('#show-leads-list').click(function() {
		$('#leads-feed').toggle();
	});
	$('#show-projects-list').click(function() {
		$('#projects-feed').toggle();
	});
	// Admin Page
	// Add/Update/Delete Users
	$('#users-table .user-form').hide();
	$('#users-table button.edit').click(function(){
		$('#users-table').find('button.edit').each(function() {
			$(this).attr('disabled', true);
		});
		$('#users-table .user-form').hide();
		$userToEdit = $(this).attr('id');
		//alert($userToEdit);
		$(this).parent().parent().find('td').fadeTo("fast",0.5).css({
			'background':'#ddd',
			'border-bottom':'none',
		});
		$(this).parent().parent().find('td').first().css({
			'border-left':'1px solid rgba(32,32,32,0.2)'
		});
		$(this).parent().parent().find('td').last().css({
			'border-right':'1px solid rgba(32,32,32,0.2)'
		});
		$(this).parent().parent().parent().find('#user-'+$userToEdit).toggle();
	});
	$('#users-table button.cancel').click(function(){
		$('#users-table').find('button.edit').each(function() {
			$(this).attr('disabled', false);
		});
		$('#users-table .user-form').hide();
		$userToCancel = $(this).attr('id');
		$(this).parent().parent().parent().parent().find('.user-list-'+$userToCancel+' td').fadeTo("fast",1).css({
			'background':'#fff',
			'border-left':'none',
			'border-right':'none',
			'border-bottom':'1px solid rgba(32,32,32,0.1)'
		});
	});
	//Change color of high priority project items
	$(document).on('change','.priority',function(){
   		var priority = $(this).val()
   		if(priority == 'High') {
   			$(this).parent().parent().parent().addClass('high-priority');
   		}
   		else {
   			$(this).parent().parent().parent().removeClass('high-priority');
   		}
		
	});
	
	//for search icon popup
	$('#link-search').click( function() {
		$('#search-box').show();
		$('#search-box p').focus();
		$('#search-box input.search').focus();
	});
	$('#search-box').click( function(ev) {
		// hide if clicking on greyed out area
		if ( $(ev.target).attr('id') != 'search-box' )
			return;
		$('#search-box input.search').blur();
		$(this).hide();
	});
	$('#search-box input').keyup( function(ev) {
		// hide if press esc
		if ( ev.keyCode == 27 ) {
			$(this).blur();
			$('#search-box').hide();
		}
	});
	$('body').keydown( function( event ) {
		if ( event.which == 191 ) { // '/' really. slash.
			if ( $('input, textarea').is(":focus") ) {} else {
			event.preventDefault();
				$('#search-box').show();
				$('#search-box input.search').focus();
			}
		}
	});
});