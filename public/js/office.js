jQuery(document).ready(function($){
	// Listen for ajax events and update page (still in development)
	var userListLengthOnLoad = $('.user-list').length;
	// setInterval(function(){
	// 	var userListLengthWithNew = $('.user-list').length;
	// 	if(userListLengthWithNew > userListLengthOnLoad) {
	// 		console.log('item added.');
			
	// 	}
	// 	else if(userListLengthWithNew < userListLengthOnLoad) {
	// 		console.log('item deleted.');
	// 	}
	// 	console.log('old: ' + userListLengthOnLoad + ' new: ' + userListLengthWithNew);
	// }, 5000);
	
	$('#projects-feed').hide();
	$('#leads-feed').hide();

	//Update active status of a menu link (both top menu bar and user menu bar)
	var currentPage = window.location.pathname;
	currentPage = currentPage.replace("/", "");
	$('#menu_links').find('li').each(function(){
		var linkActiveMain = $(this).attr('id');
		linkActiveMain = linkActiveMain.replace("link-", "");
		$(this).removeClass('active');
		if(currentPage.indexOf(linkActiveMain) >= 0 ) $(this).addClass('active');
		if(currentPage == '' && linkActiveMain == 'dashboard') $(this).addClass('active');
	});
	$('#user-menu ul').find('li').each(function(){
		var linkActiveUser = $(this).attr('id');
		linkActiveUser = linkActiveUser.replace("link-", "");
		$(this).removeClass('active');
		if(currentPage.indexOf(linkActiveUser) >= 0 ) $(this).addClass('active');
	});

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
	$(document).on('click','#users-table button.edit',function(){
		// Get current user ID
		var userRow = $(this).attr('id');

		// Set this user as being actively edited
		$(this).parent().parent().addClass('activeEdit');

		// Disable edit buttons on other users
		$('#users-table').find('button.edit').each(function() {
			$(this).attr('disabled', true);
			$(this).css('cursor', 'not-allowed');
		});

		// Fade and disable other user lists and elements
		$('#users-table').find('.user-list').each(function(index,Element) {
			if($(this).is('.activeEdit')) { }
			else {
				$(this).fadeTo("fast",0.5);
				$(this).css('cursor', 'not-allowed');				
			}
		});
		$('.success-notice').hide();
		$('.error-notice').hide();

		// Reenable active user area
		$(this).attr('disabled', false);
		$(this).css('cursor', 'pointer');
		
		// Replace list with form for this user by ID
		var userListOriginal = $('tr.user-list-'+ userRow).find('td');
					//console.log(userListOriginal);
		var userFirstNameVal = $(this).parent().parent().find('.user-name').attr('fieldvalfirst');
		var userLastNameVal = $(this).parent().parent().find('.user-name').attr('fieldvallast');
		var userLastLogin = $(this).parent().parent().find('.user-name .last-login');
		var userEmailVal = $(this).parent().parent().find('.user-email').attr('fieldval');
		var userUserroleVal = $(this).parent().parent().find('.user-userrole').attr('fieldval');
		var userExtensionVal = $(this).parent().parent().find('.user-extension').attr('fieldval');
		var userCellPhoneVal = $(this).parent().parent().find('.user-cell-phone').attr('fieldval');
		var userStatusVal = $(this).parent().parent().find('.user-status').attr('fieldval');
		$(this).parent().parent().load('/admin', function() {
			// Set form ID
			$(this).find('form').attr('id',userRow);

			// Set width of form fields for better display
			var userNameWidth = $(this).parent().find('.title-name').width();
			var userEmailWidth = $(this).parent().find('.title-email').width();
			var userPasswordWidth = $(this).parent().find('.title-password').width();
			var userUserroleWidth = $(this).parent().find('.title-userrole').width();
			var userExtensionWidth = $(this).parent().find('.title-extension').width();
			var userCellPhoneWidth = $(this).parent().find('.title-cell-phone').width();
			var userStatusWidth = $(this).parent().find('.title-status').width();
			$(this).find('form#' + userRow + ' input[name="id"]').val(userRow);
			$(this).find('form#' + userRow + ' input.first-name').val(userFirstNameVal).css('width',((userNameWidth)/2)-6+'px');
			$(this).find('form#' + userRow + ' input.last-name').val(userLastNameVal).css('width',((userNameWidth)/2)-6+'px');
			$(this).find('form#' + userRow + ' input.email').val(userEmailVal).css('width',(userEmailWidth-4)+'px');
			$(this).find('form#' + userRow + ' input[name="password"]').css('width',(userPasswordWidth-4)+'px');
			$(this).find('form#' + userRow + ' select[name="userrole"]').val(userUserroleVal).css('width',(userUserroleWidth-4)+'px');
			$(this).find('form#' + userRow + ' input.extension').val(userExtensionVal).css('width',(userExtensionWidth-4)+'px');
			$(this).find('form#' + userRow + ' input.cell-phone').val(userCellPhoneVal).css('width',(userCellPhoneWidth-4)+'px');
			$(this).find('form#' + userRow + ' select[name="status"]').val(userStatusVal).css('width',(userStatusWidth-4)+'px');

			// Cancel form: hide form, display original user list
			$(document).on('click','.activeEdit span.cancel',function(){
				$('.success-notice').hide();
				$('.error-notice').hide();
				//console.log(userListOriginal);
				$('tr.user-list-'+ userRow).html(userListOriginal).removeClass('activeEdit');
				$('#users-table').find('button.edit').each(function() {
					$(this).attr('disabled', false);
					$(this).css('cursor', 'pointer');
				});
				$('#users-table').find('.user-list').each(function() {
					$(this).fadeTo("slow",1);
					$(this).css('cursor', 'inherit');
				});
			});

			// Update a user
			$('.activeEdit form.update-user').on('submit', function(){
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
						if(data.errorMsg) {
							if(data.errorMsg == 'The email format is invalid.') $('.error-notice p').html('Only @insideout.com accounts are allowed.');
							else $('.error-notice p').html(data.errorMsg);
							$('.error-notice').show().delay(5000).fadeOut();
							//var dataObj = JSON.parse(data.errorMsg);
							//console.log(data.errorMsg);
							//$('.error-notice').show().delay(4000).fadeOut();
						}
						else {
							$('tr.activeEdit').html(userListOriginal).removeClass('activeEdit');
							$('.error-notice p').html(data.msg);
							$('.success-notice').show().delay(5000).fadeOut();

							$('#users-table .user-list-'+formID+' .user-name').html('<div>' + data.first_name +' '+ data.last_name + '</div>');
							$('#users-table .user-list-'+formID+' .user-name div').append(userLastLogin);
							$('#users-table .user-list-'+formID+' .user-email').html(data.email);
							$('#users-table .user-list-'+formID+' .user-userrole').html(data.userrole);
							$('#users-table .user-list-'+formID+' .user-extension').html(data.extension);
							$('#users-table .user-list-'+formID+' .user-cell-phone').html(data.cell_phone);
							if(data.status == 'active')
								$('#users-table .user-list-'+formID+' .user-status').html('<span class="ss-check"></span>');
							else
								$('#users-table .user-list-'+formID+' .user-status').html('<span class="ss-delete"></span>');
							$('.success-notice p').html(data.first_name + ' ' + data.last_name + ' ' + data.msg);
							$('#users-table .user-list-'+formID+' .user-name').attr('fieldvalfirst',data.first_name);
							$('#users-table .user-list-'+formID+' .user-name').attr('fieldvallast',data.last_name);
							$('#users-table .user-list-'+formID+' .user-email').attr('fieldval',data.email);
							$('#users-table .user-list-'+formID+' .user-userrole').attr('fieldval',data.userrole);
							$('#users-table .user-list-'+formID+' .user-extension').attr('fieldval',data.extension);
							$('#users-table .user-list-'+formID+' .user-cell-phone').attr('fieldval',data.cell_phone);
							$('#users-table .user-list-'+formID+' .user-status').attr('fieldval',data.status);
						}
					},'json'
				);
				$('.success-notice p').empty();
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

			// // Delete a user
			$('.activeEdit form.delete-user').on('submit', function(){
				var deleteConfirm = confirm('Delete user? This cannot be undone.');
				if(deleteConfirm == true) {
					var deleteID = $(this).attr('id');
					$.post(
						$(this).prop('action'),
						{
							"_token" : $( this ).find( 'input[name=_token]' ).val(),
							"id" : deleteID,
							"first_name" : $(this).find('input.first-name').val(),
							"last_name" : $(this).find('input.last-name').val(),
							"confirm-delete" : $( this ).find( 'input[name=confirm-delete]' ).val(),
						}, function (data) {
							//console.log(data);
							$('.error-notice p').html(data.first_name + ' ' + data.last_name + ' ' + data.msg);
							//$('#users-table .user-list-'+deleteID).remove();
							// $('#users-table #user-' + deleteID).fadeOut("slow").remove();
						},'json'
					);
					$('tr.activeEdit').remove();
					$('.error-notice').show().delay(5000).fadeOut();
					$('.error-notice p').empty();
					$('#users-table').find('button.edit').each(function() {
						$(this).attr('disabled', false);
						$(this).css('cursor', 'pointer');
					});
					$('#users-table').find('.user-list').each(function() {
						$(this).fadeTo("slow",1);
						$(this).css('cursor', 'inherit');
					});

				}
				else {
					$('.error-notice p').empty();
					$('#users-table').find('button.edit').each(function() {
						$(this).attr('disabled', false);
						$(this).css('cursor', 'pointer');
					});
					$('#users-table').find('.user-list').each(function() {
						$(this).fadeTo("slow",1);
						$(this).css('cursor', 'inherit');
					});
					$('tr.activeEdit').html(userListOriginal).removeClass('activeEdit');
					$(this).parent().parent().parent().parent().find('.user-list-'+deleteID+' td').fadeTo("slow",1);
				}
				return false;
			});
		});
	});
	
	// Add New User
	$(document).on('click','#users-table button.add-new',function(){
		$(this).parent().parent().hide();
		$('.success-notice').hide();
		$('.error-notice').hide();
		
		$(this).parent().parent().parent().find('#user-new').fadeTo("slow",1);
		var userNameWidth = $(this).parent().parent().parent().find('.title-name').width();
		var userEmailWidth = $(this).parent().parent().parent().find('.title-email').width();
		var userPasswordWidth = $(this).parent().parent().parent().find('.title-password').width();
		var userUserroleWidth = $(this).parent().parent().parent().find('.title-userrole').width();
		var userExtensionWidth = $(this).parent().parent().parent().find('.title-extension').width();
		var userCellPhoneWidth = $(this).parent().parent().parent().find('.title-cell-phone').width();
		var userStatusWidth = $(this).parent().parent().parent().find('.title-status').width();
		//alert(userNameWidth);
		$(this).parent().parent().parent().find('#user-new input.first-name').css('width',((userNameWidth)/2)-6+'px').focus();
		$(this).parent().parent().parent().find('#user-new input.last-name').css('width',((userNameWidth)/2)-6+'px');
		$(this).parent().parent().parent().find('#user-new input.email').css('width',(userEmailWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-new input[name="password"]').css('width',(userPasswordWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-new select[name="userrole"]').css('width',(userUserroleWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-new input.extension').css('width',(userExtensionWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-new input.cell-phone').css('width',(userCellPhoneWidth-4)+'px');
		$(this).parent().parent().parent().find('#user-new select[name="status"]').css('width',(userStatusWidth-4)+'px');
	});
	$('#users-table .user-add-form span.cancel').click(function(){
		$('.success-notice').hide();
		$('.error-notice').hide();
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
					if(data.errorMsg == 'The email format is invalid.') $('.error-notice p').html('Only @insideout.com accounts are allowed.');
					else $('.error-notice p').html(data.errorMsg);
					$('.error-notice').show().delay(5000).fadeOut();
				}
				else {
					$('.success-notice p').html(data.first_name + ' ' + data.last_name + ' ' + data.msg);
					$('#users-table #user-new').hide();
					$('#users-table button.add-new').parent().parent().fadeTo("slow",1);
					$('#users-table .user-list').last().after("<tr class='user-list user-list-"+data.id+"'>"+
							"<td class='user-name'  fieldvalfirst='"+data.first_name+"' fieldvallast='"+data.last_name+"'>"+data.first_name+" "+data.last_name+"</td>"+
							"<td class='user-email' fieldval='"+data.email+"'>"+data.email+"</td>"+
							"<td class='user-password'>********</td>"+
							"<td class='user-userrole' fieldval='"+data.userrole+"'>"+data.userrole+"</td>"+
							"<td class='user-extension' fieldval='"+data.extension+"'>"+data.extension+"</td>"+
							"<td class='user-cell-phone' fieldval='"+data.cell_phone+"'>"+data.cell_phone+"</td>"+
							"<td class='user-status' fieldval='"+data.status+"'><span class='ss-check'></span></td>"+
							"<td class='user-edit'>"+
								"<button id='" + data.id + "' class='edit ss-write'></button>" +
							"</td>"+
						"</tr>");
					$('#users-table .user-add-form #add-new').find('input.field').each(function(){
						$(this).val('');
					});
					$('.success-notice').show().delay(5000).fadeOut();
				}
			},'json'
		);
		$('.success-notice p').empty();
		return false;
	});
	/************/

	/* Profile Page */
	// Update your profile
	$(document).on('click','#profile-details button.edit-profile',function(){
		// Get current user ID
		var ProfileID = $(this).attr('id');

		$('.success-notice').hide();
		$('.error-notice').hide();

		// Replace list with form for this user by ID
		var profileDetailsOriginal = $('#profile-page #profile-details').find('table');
		var profileFirstNameVal = $(this).parent().parent().parent().parent().find('.profile-first-name').attr('fieldval');
		var profileFirstNameValLowercase = profileFirstNameVal.toLowerCase();
		var profileLastNameVal = $(this).parent().parent().parent().parent().find('.profile-last-name').attr('fieldval');
		var profileLastNameValLowercase = profileLastNameVal.toLowerCase();
		var profileEmailVal = $(this).parent().parent().parent().parent().find('.profile-email').attr('fieldval');
		var profileExtensionVal = $(this).parent().parent().parent().parent().find('.profile-extension').attr('fieldval');
		var profileCellPhoneVal = $(this).parent().parent().parent().parent().find('.profile-cell-phone').attr('fieldval');
		$(this).parent().parent().parent().parent().parent().load('/profile/'+profileFirstNameValLowercase+'-'+profileLastNameValLowercase, function() {
			// Set form ID
			$(this).find('form').attr('id',ProfileID);

			$(this).find('form#' + ProfileID + ' input[name="id"]').val(ProfileID);
			$(this).find('form#' + ProfileID + ' input.first-name').val(profileFirstNameVal).focus();
			$(this).find('form#' + ProfileID + ' input.last-name').val(profileLastNameVal);
			$(this).find('form#' + ProfileID + ' input.email').val(profileEmailVal);
			$(this).find('form#' + ProfileID + ' input.extension').val(profileExtensionVal);
			$(this).find('form#' + ProfileID + ' input.cell-phone').val(profileCellPhoneVal);

			// Cancel form: hide form, display original profile details
			$(document).on('click','form#' + ProfileID + ' span.cancel',function(){
				$('.success-notice').hide();
				$('.error-notice').hide();
				$('#profile-page').find('#profile-details').html(profileDetailsOriginal);
			});

			// Update Profile Ajax style
			$('#profile-details form.update-profile').on('submit', function(){
				var formID = $(this).attr('id');
				$('.success-notice').hide();
				$('.error-notice').hide();
				$.post(
					$(this).prop('action'),
					{
						"_token" : $( this ).find( 'input[name=_token]' ).val(),
						"id" : formID,
						"confirm-profile-update" : $( this ).find( 'input[name=confirm-profile-update]' ).val(),
						"first_name" : $(this).find('input.first-name').val(),
						"last_name" : $(this).find('input.last-name').val(),
						"password" : $(this).find('input.password').val(),
						"password_again" : $(this).find('input.password_again').val(),
						"extension" : $(this).find('input.extension').val(),
						"cell_phone" : $(this).find('input.cell-phone').val()
					}, function (data) {
						if(data.errorMsg) {
							if(data.errorMsg == 'The email format is invalid.') $('.error-notice p').html('Only @insideout.com accounts are allowed.');
							else $('.error-notice p').html(data.errorMsg);
							$('.error-notice').show().delay(5000).fadeOut();
						}
						else {
							$('#profile-page').find('#profile-details').html(profileDetailsOriginal);
							$('.success-notice p').html(data.msg);
							$('.success-notice').show().delay(5000).fadeOut();

							$('#profile-details .profile-first-name').html(data.first_name);
							$('#profile-details .profile-last-name').html(data.last_name);
							$('#profile-details .profile-extension').html(data.extension);
							$('#profile-details .profile-cell-phone').html(data.cell_phone);

							$('.success-notice p').html('Profile ' + data.msg);
							$('#profile-details .profile-first-name').attr('fieldval',data.first_name);
							$('#profile-details .profile-last-name').attr('fieldval',data.last_name);
							$('#profile-details .profile-extension').attr('fieldval',data.extension);
							$('#profile-details .profile-cell-phone').attr('fieldval',data.cell_phone);
						}
					},'json'
				);
				$('.success-notice p').empty();
				
				return false;
			});
		});
	});
	
	/* News Page */
	$(document).on('click','#news-page .filter-all', function(){
		window.location.href='/news/';
	});
	$(document).on('change','#news-page .filter-author', function(){
		var authorLink = $(this).val();
		window.location.href='/news/author/'+authorLink;
	});
	$('#news-page .filter-date').datepicker().on('changeDate', function(ev) {
		$('.dropdown-menu').hide();
		var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
		var dateLink = new Date(ev.date.valueOf());
		var yearLink = dateLink.getFullYear();
		var monthLink = months[dateLink.getMonth()];
		window.location.href='/news/'+yearLink+'/'+monthLink;

	});

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