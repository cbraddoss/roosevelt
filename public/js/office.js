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
			$(this).css('cursor', 'not-allowed');
		});
		$('#users-table .user-form').hide();
		var userRow = $(this).attr('id');
		//alert($userToEdit);
		$(this).parent().parent().find('td').hide();
		$('#users-table').find('.user-list').each(function() {
			$(this).fadeTo("slow",0.5);
			$(this).css('cursor', 'not-allowed');
		});
		$(this).parent().parent().parent().find('#user-'+userRow).fadeTo("slow",1);
		var userNameWidth = $(this).parent().parent().parent().find('.title-name').width();
		var userEmailWidth = $(this).parent().parent().parent().find('.title-email').width();
		var userPasswordWidth = $(this).parent().parent().parent().find('.title-password').width();
		var userUserroleWidth = $(this).parent().parent().parent().find('.title-userrole').width();
		var userExtensionWidth = $(this).parent().parent().parent().find('.title-extension').width();
		var userCellPhoneWidth = $(this).parent().parent().parent().find('.title-cell-phone').width();
		var userStatusWidth = $(this).parent().parent().parent().find('.title-status').width();
		//alert(userNameWidth);
		$(this).parent().parent().parent().find('#user-'+userRow+' input.first-name').css('width',((userNameWidth)/2)-6+'px');
		$(this).parent().parent().parent().find('#user-'+userRow+' input.last-name').css('width',((userNameWidth)/2)-6+'px');
		$(this).parent().parent().parent().find('#user-'+userRow+' input.email').css('width',(userEmailWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-'+userRow+' input[name="password"]').css('width',(userPasswordWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-'+userRow+' input.userrole').css('width',(userUserroleWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-'+userRow+' input.extension').css('width',(userExtensionWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-'+userRow+' input.cell-phone').css('width',(userCellPhoneWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-'+userRow+' input.status').css('width',(userStatusWidth-4)+'px');
	});
	$('#users-table button.cancel').click(function(){
		$('#users-table').find('button.edit').each(function() {
			$(this).attr('disabled', false);
			$(this).css('cursor', 'pointer');
		});
		$('#users-table').find('.user-list').each(function() {
			$(this).fadeTo("slow",1);
			$(this).css('cursor', 'inherit');
		});
		$('#users-table .user-form').hide();
		var userRow = $(this).attr('id');
		$(this).parent().parent().parent().parent().find('.user-list-'+userRow+' td').fadeTo("slow",1);
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