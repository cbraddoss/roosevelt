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
	
	/* Admin Page */
	/* Add/Update/Delete Users */

	// Hide all forms (find better way to do this?)
	$('#users-table .user-form').hide();

	// Update a user
	$('#users-table button.edit').click(function(){
		$('#users-table').find('button.edit').each(function() {
			$(this).attr('disabled', true);
			$(this).css('cursor', 'not-allowed');
		});
		//$('#users-table .user-form').hide();
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
		$(this).parent().parent().parent().find('#user-'+userRow+' select[name="userrole"]').css('width',(userUserroleWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-'+userRow+' input.extension').css('width',(userExtensionWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-'+userRow+' input.cell-phone').css('width',(userCellPhoneWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-'+userRow+' select[name="status"]').css('width',(userStatusWidth-4)+'px');

	});
	$('#users-table .user-update-form span.cancel').click(function(){
		$('#users-table').find('button.edit').each(function() {
			$(this).attr('disabled', false);
			$(this).css('cursor', 'pointer');
		});
		$('#users-table').find('.user-list').each(function() {
			$(this).fadeTo("slow",1);
			$(this).css('cursor', 'inherit');
		});
		var userRow = $(this).attr('id');
		$('#users-table #user-'+userRow).hide();
		
		$(this).parent().parent().parent().parent().parent().find('.user-list-'+userRow+' td').fadeTo("slow",1);
	});
	$('#users-table .user-update-form form.update-user').each(function() {
		$(this).on('submit', function(){
			var formID = $(this).attr('id');
			//alert($(this).find('input.cell-phone').val());
			$.post(
				$(this).prop('action'),
				{
					"_token" : $( this ).find( 'input[name=_token]' ).val(),
					"id" : formID,
					"confirm-update" : $( this ).find( 'input[name=confirm-update]' ).val(),
					"first_name" : $(this).find('input.first-name').val(),
					"last_name" : $(this).find('input.last-name').val(),
					"email" : $(this).find('input.email').val(),
					"password" : $(this).find('input.password').val(),
					"userrole" : $(this).find('select[name=userrole]').val(),
					"extension" : $(this).find('input.extension').val(),
					"cell_phone" : $(this).find('input.cell-phone').val(),
					"status" : $(this).find('select[name=status]').val()
				}, function (data) {
					//alert(target);
					$('#users-table .user-list-'+formID+' .user-name').html(data.first_name +' '+ data.last_name);
					$('#users-table .user-list-'+formID+' .user-email').html(data.email);
					$('#users-table .user-list-'+formID+' .user-userrole').html(data.userrole);
					$('#users-table .user-list-'+formID+' .user-extension').html(data.extension);
					$('#users-table .user-list-'+formID+' .user-cell-phone').html(data.cell_phone);
					if(data.status == 'active')
						$('#users-table .user-list-'+formID+' .user-status').html('<span class="ss-check"></span>');
					else
						$('#users-table .user-list-'+formID+' .user-status').html('<span class="ss-delete"></span>');
					$('#admin-page .user-updated p').html(data.first_name + ' ' + data.last_name + ' ' + data.msg);
				},'json'
			);
			$('#admin-page .user-updated').show().delay(4000).fadeOut();
			$('#admin-page .user-updated p').empty();
			$('#users-table').find('button.edit').each(function() {
				$(this).attr('disabled', false);
				$(this).css('cursor', 'pointer');
			});
			$('#users-table').find('.user-list').each(function() {
				$(this).fadeTo("slow",1);
				$(this).css('cursor', 'inherit');
			});
			$('#users-table #user-'+formID).hide();
			$(this).parent().parent().parent().parent().find('.user-list-'+formID+' td').fadeTo("slow",1);
			
			return false;
		});
	});

	// Delete a user
	$('#users-table .user-update-form form.delete-user').each(function() {
		$(this).on('submit', function(){
			var deleteConfirm = confirm('Delete user? This cannot be undone.');
			if(deleteConfirm == true) {
				var deleteID = $(this).attr('id');
				//alert($(this).find('input.cell-phone').val());
				$.post(
					$(this).prop('action'),
					{
						"_token" : $( this ).find( 'input[name=_token]' ).val(),
						"id" : deleteID,
						"first_name" : $(this).find('input[name=first_name]').val(),
						"last_name" : $(this).find('input[name=last_name]').val(),
						"confirm-delete" : $( this ).find( 'input[name=confirm-delete]' ).val(),
					}, function (data) {
						//alert(target);
						$('#admin-page .user-deleted p').html(data.first_name + ' ' + data.last_name + ' ' + data.msg);
						$('#users-table .user-list-'+deleteID).remove();
					},'json'
				);
				$('#admin-page .user-deleted').show().delay(4000).fadeOut();
				$('#admin-page .user-deleted p').empty();
				$('#users-table').find('button.edit').each(function() {
					$(this).attr('disabled', false);
					$(this).css('cursor', 'pointer');
				});
				$('#users-table').find('.user-list').each(function() {
					$(this).fadeTo("slow",1);
					$(this).css('cursor', 'inherit');
				});
				$('#users-table #user-' + deleteID).fadeOut("slow").remove();

			}
			else {
				$('#users-table').find('button.edit').each(function() {
					$(this).attr('disabled', false);
					$(this).css('cursor', 'pointer');
				});
				$('#users-table').find('.user-list').each(function() {
					$(this).fadeTo("slow",1);
					$(this).css('cursor', 'inherit');
				});
				$('#users-table .user-form').hide();
				$(this).parent().parent().parent().parent().find('.user-list-'+formID+' td').fadeTo("slow",1);
			}
			return false;
		});
	});
	
	// Add New User
	$('#users-table button.add-new').click(function(){
		$(this).parent().parent().hide();
		
		$(this).parent().parent().parent().find('#user-new').fadeTo("slow",1);
		var userNameWidth = $(this).parent().parent().parent().find('.title-name').width();
		var userEmailWidth = $(this).parent().parent().parent().find('.title-email').width();
		var userPasswordWidth = $(this).parent().parent().parent().find('.title-password').width();
		var userUserroleWidth = $(this).parent().parent().parent().find('.title-userrole').width();
		var userExtensionWidth = $(this).parent().parent().parent().find('.title-extension').width();
		var userCellPhoneWidth = $(this).parent().parent().parent().find('.title-cell-phone').width();
		var userStatusWidth = $(this).parent().parent().parent().find('.title-status').width();
		//alert(userNameWidth);
		$(this).parent().parent().parent().find('#user-new input.first-name').css('width',((userNameWidth)/2)-6+'px');
		$(this).parent().parent().parent().find('#user-new input.last-name').css('width',((userNameWidth)/2)-6+'px');
		$(this).parent().parent().parent().find('#user-new input.email').css('width',(userEmailWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-new input[name="password"]').css('width',(userPasswordWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-new select[name="userrole"]').css('width',(userUserroleWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-new input.extension').css('width',(userExtensionWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-new input.cell-phone').css('width',(userCellPhoneWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-new select[name="status"]').css('width',(userStatusWidth-4)+'px');
	});
	$('#users-table .user-add-form span.cancel').click(function(){
		$(this).parent().find('input.field').each(function(){
			$(this).val('');
		});
		$(this).parent().parent().parent().parent().parent().find('#user-new').hide();
		$('#users-table button.add-new').parent().parent().fadeTo("slow",1);
	});
	$('#users-table .user-add-form form.add-user').on('submit', function(){
		$.post(
			$(this).prop('action'),
			{
				"_token" : $( this ).find( 'input[name=_token]' ).val(),
				"confirm-add" : $( this ).find( 'input[name=confirm-add]' ).val(),
				"first_name" : $(this).find('input.first-name').val(),
				"last_name" : $(this).find('input.last-name').val(),
				"email" : $(this).find('input.email').val(),
				"password" : $(this).find('input.password').val(),
				"userrole" : $(this).find('select[name=userrole]').val(),
				"extension" : $(this).find('input.extension').val(),
				"cell_phone" : $(this).find('input.cell-phone').val(),
				"status" : $(this).find('select[name=status]').val()
			}, function (data) {
				if(data.errorMsg) {
					$('#admin-page .user-updated p').html(data.errorMsg);
					
				}
				else {
					$('#admin-page .user-updated p').html(data.first_name + ' ' + data.last_name + ' ' + data.msg);
					$('#users-table #user-new').hide();
					$('#users-table button.add-new').parent().parent().fadeTo("slow",1);
					$('#users-table .user-list').last().after("<tr class='user-list user-list-"+data.id+"'>"+
							"<td class='user-name'>"+data.first_name+" "+data.last_name+"</td>"+
							"<td class='user-email'>"+data.email+"</td>"+
							"<td class='user-password'>********</td>"+
							"<td class='user-userrole'>"+data.userrole+"</td>"+
							"<td class='user-extension'>"+data.extension+"</td>"+
							"<td class='user-cell-phone'>"+data.cell_phone+"</td>"+
							"<td class='user-status'><span class='ss-check'></span></td>"+
							"<td class='user-edit'>"+
								"<button id='"+data.id+"' class='edit ss-write'></button>"+
							"</td>"+
						"</tr>");
					$('#users-table .user-add-form #add-new').find('input.field').each(function(){
						$(this).val('');
					});
				}
			},'json'
		);
		$('#admin-page .user-updated').show().delay(4000).fadeOut();
		$('#admin-page .user-updated p').empty();
		return false;
	});
	/************/

	/* Projects Page */
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