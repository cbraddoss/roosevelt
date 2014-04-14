jQuery(document).ready(function($){
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

	var welcomes = new Array('Welcome','Willkommen','स्वागत','Bienvenue','歡迎光臨','Wëllkomm','Bienvenido','ようこそ','Welcome');
	var i = 1;
	if(currentPage == '') {
		function welcomeLoop () {
		   setTimeout(function () {
			console.log(welcomes[i]);
		      $('#user-menu #welcome-name .welcome').html(welcomes[i]);
		      i++;
		      if (i < 9) {
		         welcomeLoop();
		      }
		   }, 10000)
		}
		welcomeLoop();
	}

	//Show/hide task items in sidebar
	$('#projects-feed').hide();
	$('#leads-feed').hide();
	$('#show-tasks-list').click(function() {
		$('#tasks-feed').toggle();
		$(this).find('a.todo-feed-title').toggleClass('active');
		$(this).find('span.arrow').toggleClass('ss-dropdown');
		$(this).find('span.arrow').toggleClass('ss-directleft');
	});
	$('#show-leads-list').click(function() {
		$('#leads-feed').toggle();
		$(this).find('a.todo-feed-title').toggleClass('active');
		$(this).find('span.arrow').toggleClass('ss-dropdown');
		$(this).find('span.arrow').toggleClass('ss-directleft');
	});
	$('#show-projects-list').click(function() {
		$('#projects-feed').toggle();
		$(this).find('a.todo-feed-title').toggleClass('active');
		$(this).find('span.arrow').toggleClass('ss-dropdown');
		$(this).find('span.arrow').toggleClass('ss-directleft');
	});
	
	$('#message-box').hide();
	$('#message-box-json').hide();
	$('#message-box').fadeIn();
	$('#message-box .action-message .flash-message-success').parent().parent().parent().delay(7000).fadeOut();

	/* Admin Page */
	/* Add/Update/Delete Users */

	// Hide all forms (find better way to do this?)
	//$('#users-table .user-form').hide();

	// Update a user
	// $(document).on('click','#users-table button.edit',function(){
	// 	// Get current user ID
	// 	var userRow = $(this).attr('id');

	// 	// Set this user as being actively edited
	// 	$(this).parent().parent().addClass('activeEdit');

	// 	// Disable edit buttons on other users
	// 	$('#users-table').find('button.edit').each(function() {
	// 		$(this).attr('disabled', true);
	// 		$(this).css('cursor', 'not-allowed');
	// 	});

	// 	// Fade and disable other user lists and elements
	// 	$('#users-table').find('.user-list').each(function(index,Element) {
	// 		if($(this).is('.activeEdit')) { }
	// 		else {
	// 			$(this).fadeTo("fast",0.5);
	// 			$(this).css('cursor', 'not-allowed');				
	// 		}
	// 	});
	// 	$('.success-notice').hide();
	// 	$('.error-notice').hide();

	// 	// Reenable active user area
	// 	$(this).attr('disabled', false);
	// 	$(this).css('cursor', 'pointer');
		
	// 	// Replace list with form for this user by ID
	// 	var userListOriginal = $('tr.user-list-'+ userRow).find('td');
	// 				//console.log(userListOriginal);
	// 	var userFirstNameVal = $(this).parent().parent().find('.user-name').attr('fieldvalfirst');
	// 	var userLastNameVal = $(this).parent().parent().find('.user-name').attr('fieldvallast');
	// 	var userLastLogin = $(this).parent().parent().find('.user-name .last-login');
	// 	var userEmailVal = $(this).parent().parent().find('.user-email').attr('fieldval');
	// 	var userUserroleVal = $(this).parent().parent().find('.user-userrole').attr('fieldval');
	// 	var userExtensionVal = $(this).parent().parent().find('.user-extension').attr('fieldval');
	// 	var userCellPhoneVal = $(this).parent().parent().find('.user-cell-phone').attr('fieldval');
	// 	var userStatusVal = $(this).parent().parent().find('.user-status').attr('fieldval');
	// 	$(this).parent().parent().load('/admin', function() {
	// 		// Set form ID
	// 		$(this).find('form').attr('id',userRow);

	// 		// Set width of form fields for better display
	// 		var userNameWidth = $(this).parent().find('.title-name').width();
	// 		var userEmailWidth = $(this).parent().find('.title-email').width();
	// 		var userPasswordWidth = $(this).parent().find('.title-password').width();
	// 		var userUserroleWidth = $(this).parent().find('.title-userrole').width();
	// 		var userExtensionWidth = $(this).parent().find('.title-extension').width();
	// 		var userCellPhoneWidth = $(this).parent().find('.title-cell-phone').width();
	// 		var userStatusWidth = $(this).parent().find('.title-status').width();
	// 		$(this).find('form#' + userRow + ' input[name="id"]').val(userRow);
	// 		$(this).find('form#' + userRow + ' input.first-name').val(userFirstNameVal).css('width',((userNameWidth)/2)-6+'px');
	// 		$(this).find('form#' + userRow + ' input.last-name').val(userLastNameVal).css('width',((userNameWidth)/2)-6+'px');
	// 		$(this).find('form#' + userRow + ' input.email').val(userEmailVal).css('width',(userEmailWidth-4)+'px');
	// 		$(this).find('form#' + userRow + ' input[name="password"]').css('width',(userPasswordWidth-4)+'px');
	// 		$(this).find('form#' + userRow + ' select[name="userrole"]').val(userUserroleVal).css('width',(userUserroleWidth-4)+'px');
	// 		$(this).find('form#' + userRow + ' input.extension').val(userExtensionVal).css('width',(userExtensionWidth-4)+'px');
	// 		$(this).find('form#' + userRow + ' input.cell-phone').val(userCellPhoneVal).css('width',(userCellPhoneWidth-4)+'px');
	// 		$(this).find('form#' + userRow + ' select[name="status"]').val(userStatusVal).css('width',(userStatusWidth-4)+'px');

	// 		// Cancel form: hide form, display original user list
	// 		$(document).on('click','.activeEdit span.cancel',function(){
	// 			$('.success-notice').hide();
	// 			$('.error-notice').hide();
	// 			$('tr.user-list-'+ userRow).html(userListOriginal).removeClass('activeEdit');
	// 			$('#users-table').find('button.edit').each(function() {
	// 				$(this).attr('disabled', false);
	// 				$(this).css('cursor', 'pointer');
	// 			});
	// 			$('#users-table').find('.user-list').each(function() {
	// 				$(this).fadeTo("slow",1);
	// 				$(this).css('cursor', 'inherit');
	// 			});
	// 		});

	// 		// Update a user
	// 		$('.activeEdit form.update-user').on('submit', function(){
	// 			var formID = $(this).attr('id');
	// 			$.post(
	// 				$(this).prop('action'),
	// 				{
	// 					"_token" : $( this ).find( 'input[name=_token]' ).val(),
	// 					"id" : formID,
	// 					"confirm-update" : $( this ).find( 'input[name=confirm-update]' ).val(),
	// 					"first_name" : $(this).find('input.first-name').val(),
	// 					"last_name" : $(this).find('input.last-name').val(),
	// 					"email" : $(this).find('input.email').val(),
	// 					"password" : $(this).find('input.password').val(),
	// 					"userrole" : $(this).find('select[name=userrole]').val(),
	// 					"extension" : $(this).find('input.extension').val(),
	// 					"cell_phone" : $(this).find('input.cell-phone').val(),
	// 					"status" : $(this).find('select[name=status]').val()
	// 				}, function (data) {
	// 					if(data.errorMsg) {
	// 						if(data.errorMsg == 'The email format is invalid.') $('.error-notice p').html('Only @insideout.com accounts are allowed.');
	// 						else $('.error-notice p').html(data.errorMsg);
	// 						$('.error-notice').show().delay(5000).fadeOut();
	// 					}
	// 					else {
	// 						$('tr.activeEdit').html(userListOriginal).removeClass('activeEdit');
	// 						$('.error-notice p').html(data.msg);
	// 						$('.success-notice').show().delay(5000).fadeOut();

	// 						$('#users-table .user-list-'+formID+' .user-name').html('<div>' + data.first_name +' '+ data.last_name + '</div>');
	// 						$('#users-table .user-list-'+formID+' .user-name div').append(userLastLogin);
	// 						$('#users-table .user-list-'+formID+' .user-email').html(data.email);
	// 						$('#users-table .user-list-'+formID+' .user-userrole').html(data.userrole);
	// 						$('#users-table .user-list-'+formID+' .user-extension').html(data.extension);
	// 						$('#users-table .user-list-'+formID+' .user-cell-phone').html(data.cell_phone);
	// 						if(data.status == 'active')
	// 							$('#users-table .user-list-'+formID+' .user-status').html('<span class="ss-check"></span>');
	// 						else
	// 							$('#users-table .user-list-'+formID+' .user-status').html('<span class="ss-delete"></span>');
	// 						$('.success-notice p').html(data.first_name + ' ' + data.last_name + ' ' + data.msg);
	// 						$('#users-table .user-list-'+formID+' .user-name').attr('fieldvalfirst',data.first_name);
	// 						$('#users-table .user-list-'+formID+' .user-name').attr('fieldvallast',data.last_name);
	// 						$('#users-table .user-list-'+formID+' .user-email').attr('fieldval',data.email);
	// 						$('#users-table .user-list-'+formID+' .user-userrole').attr('fieldval',data.userrole);
	// 						$('#users-table .user-list-'+formID+' .user-extension').attr('fieldval',data.extension);
	// 						$('#users-table .user-list-'+formID+' .user-cell-phone').attr('fieldval',data.cell_phone);
	// 						$('#users-table .user-list-'+formID+' .user-status').attr('fieldval',data.status);
	// 					}
	// 				},'json'
	// 			);
	// 			$('.success-notice p').empty();
	// 			$('#users-table').find('button.edit').each(function() {
	// 				$(this).attr('disabled', false);
	// 				$(this).css('cursor', 'pointer');
	// 			});
	// 			$('#users-table').find('.user-list').each(function() {
	// 				$(this).fadeTo("slow",1);
	// 				$(this).css('cursor', 'inherit');
	// 			});
	// 			$('#users-table #user-'+formID).hide();
	// 			$(this).parent().parent().parent().parent().find('.user-list-'+formID+' td').fadeTo("slow",1);
				
	// 			return false;
	// 		});

	// 		// // Delete a user
	// 		$('.activeEdit form.delete-user').on('submit', function(){
	// 			var deleteConfirm = confirm('Delete user? This cannot be undone.');
	// 			if(deleteConfirm == true) {
	// 				var deleteID = $(this).attr('id');
	// 				$.post(
	// 					$(this).prop('action'),
	// 					{
	// 						"_token" : $( this ).find( 'input[name=_token]' ).val(),
	// 						"id" : deleteID,
	// 						"first_name" : $(this).find('input.first-name').val(),
	// 						"last_name" : $(this).find('input.last-name').val(),
	// 						"confirm-delete" : $( this ).find( 'input[name=confirm-delete]' ).val(),
	// 					}, function (data) {
	// 						$('.error-notice p').html(data.first_name + ' ' + data.last_name + ' ' + data.msg);
	// 					},'json'
	// 				);
	// 				$('tr.activeEdit').remove();
	// 				$('.error-notice').show().delay(5000).fadeOut();
	// 				$('.error-notice p').empty();
	// 				$('#users-table').find('button.edit').each(function() {
	// 					$(this).attr('disabled', false);
	// 					$(this).css('cursor', 'pointer');
	// 				});
	// 				$('#users-table').find('.user-list').each(function() {
	// 					$(this).fadeTo("slow",1);
	// 					$(this).css('cursor', 'inherit');
	// 				});

	// 			}
	// 			else {
	// 				$('.error-notice p').empty();
	// 				$('#users-table').find('button.edit').each(function() {
	// 					$(this).attr('disabled', false);
	// 					$(this).css('cursor', 'pointer');
	// 				});
	// 				$('#users-table').find('.user-list').each(function() {
	// 					$(this).fadeTo("slow",1);
	// 					$(this).css('cursor', 'inherit');
	// 				});
	// 				$('tr.activeEdit').html(userListOriginal).removeClass('activeEdit');
	// 				$(this).parent().parent().parent().parent().find('.user-list-'+deleteID+' td').fadeTo("slow",1);
	// 			}
	// 			return false;
	// 		});
	// 	});
	// });
	
	// Add New User
	$(document).on('click','#admin-page #admin-new-user-form button.add-new',function(){
		$.get( "/admin/users", function( data ) {
			$('#admin-new-user-form').html(data);
			$('form.add-user .first-name').focus();
		});
	});
	$(document).on('click','#admin-page .user-add-form span.cancel',function(){
		$('#admin-new-user-form').html('<span class="admin-button"><button class="add-new">Add New User</button></span>');
	});
	$(document).on('submit', '#admin-page .user-add-form form.add-user', function(){
		$.post(
			$(this).prop('action'),
			{
				"_token" : $( this ).find( 'input[name=_token]' ).val(),
				"first_name" : $(this).find('input.first-name').val(),
				"last_name" : $(this).find('input.last-name').val(),
				"email" : $(this).find('input.email').val(),
				"password" : $(this).find('input.password').val(),
				"userrole" : $(this).find('select[name=userrole]').val(),
			}, function (data) {
				if(data.errorMsg) {
					$('#message-box-json').fadeIn();
					if(data.errorMsg == 'The email format is invalid.') $('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">Only @insideout.com accounts are allowed.</span></div>');
					else $('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
				}
				else {
					$('#message-box-json').find('.section').empty();
					$('#message-box-json').fadeOut();
					//$('#message-box-json').fadeIn();
					//$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-success">' + data.msg + '</span></div>');
					//$('#message-box-json').delay(2000).fadeOut();
					//$('#admin-new-user-form').html('<span class="admin-button"><button class="add-new">Add New User</button></span>');
					window.location.href = '/admin/users?user=new';
				}
			},'json'
		);
		return false;
	});
	/************/
	
	/* News Page */
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
		window.location.href='/news/date/'+yearLink+'/'+monthLink;
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
		$('#search-box').fadeIn();
		$('#search-box input.search').focus();
	});
	$(document).on('click','#search-box .ss-delete',function(){
		$('#search-box input.search').blur();
		$('#search-box').fadeOut();
	});
	$('#search-box input').keyup( function(ev) {
		// hide if press esc
		if ( ev.keyCode == 27 ) {
			$(this).blur();
			$('#search-box').fadeOut();
		}
	});
	$('body').keydown( function( event ) {
		if ( event.which == 191 ) { // '/' really. slash.
			if ( $('input, textarea').is(":focus") ) {} else {
			event.preventDefault();
				$('#search-box').fadeIn();
				$('#search-box input.search').focus();
			}
		}
	});
});