<script type="text/javascript" src="/js/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="/js/jquery.colorbox-min-1.5.9.js"></script>
<script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/js/jquery.form-3.51.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
	//Colorbox popup for images
	$("a[href $= 'gif'],a[href $= 'jpg'],a[href $= 'jpeg'],a[href $= 'JPG'],a[href $= 'JPEG'],a[href $= 'PNG'],a[href $= 'png']").colorbox({ opacity: '0.6',maxHeight:'80%', maxWidth: '80%' });
	
	//Animate scroll to loaded comment id
	var commentUrlHash = window.location.hash;
	var commentUrlNew = window.location.search;
	var commentGoToPost = $(commentUrlHash).offset();
	if(commentGoToPost) {
		$('html, body').animate({
			scrollTop: commentGoToPost.top-110
		}, 2000);
	}
	if(commentUrlNew == '?comment=new') {
		$(commentUrlHash).addClass('office-post-comment-new');
	}
	if(commentUrlNew == '?comment=edit') {
		$(commentUrlHash).addClass('office-post-comment-edit');
	}

	//Update active status of a menu link (both top menu bar and page menu bar)
	var currentPage = window.location.pathname;
	currentPage = currentPage.replace("/", "");
	currentPage = currentPage.split('/');
	$('#menu_links').find('li.link').each(function(){
		var linkActiveMain = $(this).attr('id');
		linkActiveMain = linkActiveMain.replace("link-", "");
		$(this).removeClass('active');
		$(this).addClass('inactive');
		if(currentPage.indexOf(linkActiveMain) >= 0 ) {
			$(this).addClass('active');
			$(this).removeClass('inactive');
			// $(this).next('ul.sub_menu_links').css({
			// 	'visibility': 'visible'
			// }).show();
		}
		if(currentPage == '' && linkActiveMain == 'dashboard') {
			$(this).addClass('active');
			$(this).removeClass('inactive');
		}
		if(currentPage[0] == 'admin' && linkActiveMain == 'profile') {
			$(this).addClass('active');
			$(this).removeClass('inactive');
		}
		if(currentPage[0] == 'to-do' && linkActiveMain == 'profile') {
			$(this).addClass('active');
			$(this).removeClass('inactive');
		}
	});
	var currentSubPage = window.location.pathname;
	currentSubPage = currentSubPage.replace("/", "");
	currentSubPage = currentSubPage.split('/');
	$('#page-nav_menu').find('a.link').each(function() {
		var linkActivePage = $(this).attr('id');
		if(linkActivePage) {
			if(currentSubPage[1] != null) {
				linkActivePage = linkActivePage.replace("pagelink-admin-", "");
				linkActivePage = linkActivePage.replace("pagelink-to-do-", "");
				linkActivePage = linkActivePage.replace("pagelink-projects-", "");
				linkActivePage = linkActivePage.replace("pagelink-news-", "");
				linkActivePage = linkActivePage.replace("pagelink-assets-", "");
				linkActivePage = linkActivePage.replace("pagelink-tags-", "");
				//console.log(linkActivePage);
				$(this).removeClass('active');
				$(this).addClass('inactive');
				if(currentSubPage.indexOf(linkActivePage) >= 0 ) {
					$(this).addClass('active');
					$(this).removeClass('inactive');
				}
				if(currentSubPage[1] == 'status' && currentSubPage[2] == 'open' && linkActivePage == 'pagelink-projects') {
					$(this).addClass('active');
					$(this).removeClass('inactive');
				}
			}
			else {
				linkActivePage = linkActivePage.replace("pagelink-", "");
				$(this).removeClass('active');
				$(this).addClass('inactive');
				if(currentSubPage.indexOf(linkActivePage) >= 0 ) {
					$(this).addClass('active');
					$(this).removeClass('inactive');
				}
			}
		}
	});
	
	// show sub menu on hover
	$('#menu_header ul#menu_links li.link').hover(function(){
		$(this).children('ul.sub_menu_links-hover').css({
			'visibility': 'visible'
		}).slideDown(400).show();
		$(this).addClass('hover');
	},function(){
		$(this).children('ul.sub_menu_links-hover').css({
			'visibility': 'hidden'
		}).hide();
		$(this).removeClass('hover');
	});
	
	//for search icon popup
	$(document).on('click', '#menu_header .menu_nav ul#menu_links li.link#link-search', function() {
		$('body').toggleClass('search-bar-active');
		$('#header').toggleClass('search-bar-active');
		$('#nav_menu').toggleClass('search-bar-active');
		$('#header #search-box').toggle();
		$(document).find('#search-box input.search').focus();
	});

	// Add To-Do counts to menu profile link and 'view to-do list' link in header
	var projectsCount = parseInt($(document).find('#menu_header .menu_nav ul#menu_links li.link span#linked-to-projects').attr('value'),10);
	var billablesCount = parseInt($(document).find('#menu_header .menu_nav ul#menu_links li.link span#linked-to-billables').attr('value'),10);
	var helpCount = parseInt($(document).find('#menu_header .menu_nav ul#menu_links li.link span#linked-to-help').attr('value'),10);
	var todoCount = projectsCount+billablesCount+helpCount;
	if(todoCount != 0) {
		$(document).find('#menu_header .menu_nav ul#menu_links li.link#link-profile span.linked-to a').html(todoCount);
		$(document).find('#quicklinks span.user-todo').html(todoCount);
	}

	// Notification popup
	$('#message-box').slideDown(1000);
	$('#message-box .action-message .flash-message-success').parent().parent().parent().delay(7000).slideUp(1000);
	$('#message-box .action-message .flash-message-error').parent().parent().parent().delay(14000).slideUp(1000);
	$('#message-box-json').hide();
	$('#message-box-json').find('.section').empty();
	var flashMessageSuccess = sessionStorage.getItem('flash_message_success');
	var flashMessageError = sessionStorage.getItem('flash_message_error');
	if(flashMessageSuccess) {
		$('#message-box-json').slideDown(1000).find('.section').html('<div class="action-message"><span class="flash-message flash-message-success"><span class="ss-check"></span>'+flashMessageSuccess+'</span></div>');
		$('#message-box-json').delay(5000).slideUp(1000,function() {
			$(this).find('.section').empty();
		});
		sessionStorage.removeItem('flash_message_success');
	}
	if(flashMessageError) {
		$('#message-box-json').slideDown(1000).find('.section').html('<div class="action-message"><span class="flash-message flash-message-error"><span class="ss-alert"></span>'+flashMessageError+'</span></div>');
		$('#message-box-json').delay(5000).slideUp(1000,function() {
			$(this).find('.section').empty();
		});
		sessionStorage.removeItem('flash_message_error');
	}
	$(document).on('click','#message-box .close-message', function() {
		$(document).find('#message-box').slideUp(1000);
	});
	$(document).on('click','#message-box-json .close-message', function() {
		$(document).find('#message-box-json').slideUp(1000);
	});

	// keyboard action to cancel user add form
	// $(document).on('keyup','#content form input', function(ev) {
	// 	// hide if press esc
	// 	if ( ev.keyCode == 27 ) {
	// 		$(document).find('.create-something-form').slideUp(400,function(){
	// 			$(document).find('.create-something-form').remove();
	// 			$('#page-nav_menu .create-something-new .add-button').removeClass('active');
	// 			$('.add-button').each(function(){
	// 				$(this).prop('disabled', false);
	// 			});
	// 		});
	// 	}
	// });
	
	//Show '.create-something-form' form (triggered from #page-nav_menu)
	$(document).on('click','#page-nav_menu .add-button',function(){
		var getCreateUrl = $(this).attr('formlocation');
		var getFormType = $(this).attr('formtype');
		if(getCreateUrl) {
			$('.add-button').each(function(){
				$(this).prop('disabled',true);
			});
			$('.inner-page').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
			$.get( getCreateUrl, function( data ) {
				$('.add-button').each(function(){
					$(this).prop('disabled',true);
				});
				$('.inner-page').before(data);
				$(document).find('.loading-something-new').remove();
				$('.create-something-form').hide().slideDown(1000);
				$('#page-nav_menu .create-something-new [formtype='+getFormType+']').addClass('active');
				$('.create-something-form form .new-form-field input').first().focus();
				var goToForm = $(document).find('.create-something-form').offset();
				$('html, body').animate({
					scrollTop: goToForm.top-110
				}, 2000);
				//for future dates (past dates disabled)
				var dateTemp = new Date();
				var dateNow = new Date(dateTemp.getFullYear(), dateTemp.getMonth(), dateTemp.getDate(), 0, 0, 0, 0);
				var datePost = $('.create-something-form form .future-dates').datepicker({
					onRender: function(date) {
						return date.valueOf() < dateNow.valueOf() ? 'disabled' : '';
					}
				}).on('changeDate', function(ev) {
					datePost.hide();
					$(this).addClass('changed-input');
					if($(this).hasClass('project-launch-date')) {
						var launchVal = $(this).val();
						$(this).parent().parent().find('input[name=end_date]').attr('value',launchVal);
					}
					if($(this).hasClass('project-start-date')) {
						var endVal = $(this).val();
						$(this).parent().parent().find('input[name=launch_date]').attr('value',endVal);
					}
				}).data('datepicker');
				if(getFormType == 'add-project') {
					$('form.add-project .project-start-date').hide();
					$('form.add-project label[for=start_date]').hide();
					$('form.add-project .project-recur-cycle').hide();
					$('form.add-project label[for=recur_cycle]').hide();
					$(document).on('change','form.add-project select[name=period]', function() {
						var periodValue = $(this).val();
						if(periodValue == 'recurring') {
							$('form.add-project .project-launch-date').slideUp(1000);
							$('form.add-project label[for=launch_date]').slideUp(1000);
							$('form.add-project .project-launch-date').val('');
							$('form.add-project .project-start-date').slideDown(1000);
							$('form.add-project label[for=start_date]').slideDown(1000);
							$('form.add-project .project-recur-cycle').slideDown(1000);
							$('form.add-project label[for=recur_cycle]').slideDown(1000);
						}
						else {
							$('form.add-project .project-end-date').val('');
							$('form.add-project .project-start-date').slideUp(1000);
							$('form.add-project label[for=start_date]').slideUp(1000);
							$('form.add-project label[for=recur_cycle]').slideUp(1000);
							$('form.add-project .project-recur-cycle').slideUp(1000);
							$('form.add-project .project-launch-date').slideDown(1000);	
							$('form.add-project label[for=launch_date]').slideDown(1000);				
						}
					});
					// add template name from id to form
					$(document).on('change','form.add-project select[name=template_id]', function(){
						var templateIdGet = $(this).val();
						var templateIdName = $(this).find('option[value='+templateIdGet+']').text();
						$(this).parent().next('input[name=template_name]').val(templateIdName);
					});
				}
			});
		}
	});

	//Show '.create-something-form' form for comments
	$(document).on('click', '.post-comment', function(){
		var getCreateCommentUrl = $(this).attr('formlocation');
		var getCommentFormType = $(this).attr('formtype');
		var getCommentID = $(this).attr('commentid');
		var getCommentAuthor = $(document).find('#comment-'+getCommentID+' .comment-author').attr('author');
		if(getCreateCommentUrl) {
			$('.post-comment').each(function(){
				$(this).prop('disabled',true);
			});
			if(getCommentFormType == 'post-reply') $('#comments').after('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
			if(getCommentFormType == 'comment-reply') $('#comment-'+getCommentID).after('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
			$.get( getCreateCommentUrl, function( data ) {
				if(getCommentFormType == 'post-reply') {
					$('#comments').append(data);
					$('#comments .create-something-form').addClass('reply-to-post-form');
					$(document).find('.loading-something-new').remove();
					$('#comments .create-something-form').hide().slideDown(1000);
					$(document).find('span[formtype='+getCommentFormType+']').addClass('active');
				}
				if(getCommentFormType == 'comment-reply') {
					$('#comment-'+getCommentID).after(data);
					$(document).find('.inner-page .create-something-form').addClass('reply-to-comment-form');
					$(document).find('.loading-something-new').remove();
					$('.create-something-form').hide().slideDown(1000);
					$('#comment-'+getCommentID).find('.add-button').addClass('active');
					$(document).find('.create-something-form h2').html('Reply to '+getCommentAuthor+'\'s comment:');
				}
				$('.post-comment').each(function(){
					$(this).prop('disabled',true);
				});
				$('.create-something-form form .new-form-field textarea').first().focus();
				var goToForm = $(document).find('.create-something-form').offset();
				$('html, body').animate({
					scrollTop: goToForm.top-115
				}, 2000);
			});
		}
	});
	
	//POST '.create-something-form' form to intended page
	$(document).on('submit', '.create-something-form form', function(){
		//check if comment reply
		var commentReplyToId = $(document).find('.reply-to-comment-form').prev().attr('id');
		if(commentReplyToId) commentReplyToId = commentReplyToId.replace('comment-','');
		else commentReplyToId = 0;

		var createSomethingOptions = {
			target:   '#message-box-json .section',
			success:       createSomethingSuccess,
			dataType: 'json',
			resetForm: false,
			data: { reply_to_id: commentReplyToId }
		};
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
		$(this).ajaxSubmit(createSomethingOptions);
		return false;
	});
	
	function createSomethingSuccess(data) {
		if(data.errorMsg) {
			if(data.actionType == 'user-add' && data.errorMsg == 'The email format is invalid.') $('#message-box-json').slideDown(1000).find('.section').html('<div class="action-message"><span class="flash-message flash-message-error"><span class="ss-alert"></span>Only @insideout.com accounts are allowed.</span></div>');
			else if(data.actionType == 'project-add' && data.errorMsg == 'The account id field is required.') $('#message-box-json').slideDown(1000).find('.section').html('<div class="action-message"><span class="flash-message flash-message-error"><span class="ss-alert"></span>Please select an Account.</span></div>');
			else if(data.actionType == 'project-add' && data.errorMsg == 'The template id field is required.') $('#message-box-json').slideDown(1000).find('.section').html('<div class="action-message"><span class="flash-message flash-message-error"><span class="ss-alert"></span>Please select a Template.</span></div>');
			else $('#message-box-json').slideDown(1000).find('.section').html('<div class="action-message"><span class="flash-message flash-message-error"><span class="ss-alert"></span>' + data.errorMsg + '</span></div>');
		}
		else {
			if(data.windowAction) {
				sessionStorage.setItem('flash_message_success', data.msg);
				window.location.href = data.windowAction;
				if(window.location.search == '?comment=new') window.location.reload(true);
				//if(window.location.search == '?comment=edit') window.location.reload(true);
			}
			if(data.actionType == 'comment-edit') {
				$('#message-box-json').slideDown(1000).find('.section').html('<div class="action-message"><span class="flash-message flash-message-success"><span class="ss-check"></span>' + data.msg + '</span></div>');
				$(document).find('.update-something-form').slideUp(1000,function() {
					$(this).remove();
				});
				$(document).find('.comment-text.editing-this-comment').html(data.commentContent).hide().slideDown(1000, function() {
					$(this).removeClass('editing-this-comment');
				});
				var attachmentElement = $(document).find('.comment-single-attachment.editing-this-comment').length;
				if(attachmentElement > 0) {
					$(document).find('.comment-single-attachment.editing-this-comment').html(data.commentAttachment).slideDown(1000, function() {
						$(this).removeClass('editing-this-comment');
					});
				}
				else {
					$(document).find('.comment-text.editing-this-comment').before(data.commentAttachment);
					$(document).find('.comment-single-attachment').hide().slideDown(1000);
				}
				$(document).find('.comment-edit-button a.edit-comment').each(function(){
					$(this).fadeIn(400);
				});
				$(document).find('.post-comment').each(function(){
					$(this).fadeIn(400);
				});
				$('#message-box-json').delay(3000).slideUp(1000, function() {
					$(this).find('section').remove();
				});
			}
		}
	}
	
	//Cancel '.create-something-form' form
	$(document).on('click','.create-something-form span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Are you sure you want to discard changes?');
			if(confirmCancel == true) {
				$(document).find('.create-something-form').slideUp(1000,function(){
					$(document).find('.create-something-form').remove();
					$('.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
				});
				$('#message-box-json').slideUp(1000, function() {
					$(this).find('.section').empty();
				});
			}
		}
		else {
			$(document).find('.create-something-form').slideUp(1000,function(){
				$(document).find('.create-something-form').remove();
				$('.create-something-new .add-button').removeClass('active');
				$('.add-button').each(function(){
					$(this).prop('disabled', false);
				});
			});
			$('#message-box-json').slideUp(1000, function() {
				$(this).find('.section').empty();
			});
		}
	});
	
	// edit comment
	$(document).on('click', '.comment-edit-button a.edit-comment', function(){
		var getEditCommentUrl = $(this).attr('formlocation');
		var getEditFormType = $(this).attr('formtype');
		var getEditCommentID = $(this).attr('commentid');
		var getPostSlug = $(document).find('.office-post-single').attr('slug');
		$.get( getEditCommentUrl, function( data ) {
			$(document).find('.comment-edit-button a.edit-comment').each(function(){
				$(this).fadeOut(400);
			});
			$(document).find('.post-comment').each(function(){
				$(this).fadeOut(400);
			});
			$('#comment-'+getEditCommentID+' .comment-contents .comment-text').after(data);
			$('#comment-'+getEditCommentID+' .comment-contents .comment-text').slideUp(1000).addClass('editing-this-comment');
			$('#comment-'+getEditCommentID+' .comment-contents .comment-single-attachment').slideUp(1000).addClass('editing-this-comment');
			$('#comment-'+getEditCommentID+' .update-something-form').hide().slideDown(1000,function() {
				$('.update-something-form form .new-form-field textarea').first().focus();
				var goToForm = $(document).find('.update-something-form').offset();
				$('html, body').animate({
					scrollTop: goToForm.top-115
				}, 2000);
				$('#comment-'+getEditCommentID+' .comment-contents').find('input[name=article-slug]').val(getPostSlug);
				$('form.edit-comment .update-comment-content').focus();
			});
		});
	});
	
	// submit edit on comment (save for later)
	$(document).on('submit','form.edit-comment', function() {
		var editCommentOptions = { 
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       createSomethingSuccess,  // post-submit callback 
			resetForm: false        // reset the form after successful submit 
		};	 
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
	    $(this).ajaxSubmit(editCommentOptions);
	    return false;
	});
	
	//Cancel editing a comment
	$(document).on('click','form.edit-comment span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Are you sure you want to discard changes?');
		
			if(confirmCancel == true) {
				$(document).find('.changed-input').each(function() {
					$(this).removeClass('changed-input');
				});
				$(document).find('.update-something-form').slideUp(1000,function() {
					$(this).remove();
				});
				$(document).find('.editing-this-comment').each(function() {
					$(this).slideDown(1000).removeClass('editing-this-comment');
				});
				$(document).find('.comment-edit-button a.edit-comment').each(function(){
					$(this).fadeIn(400);
				});
				$(document).find('.post-comment').each(function(){
					$(this).fadeIn(400);
				});
			}
		}
		else {
			$(document).find('.update-something-form').slideUp(1000,function() {
				$(this).remove();
			});
			$(document).find('.editing-this-comment').each(function() {
				$(this).slideDown(1000).removeClass('editing-this-comment');
			});
			$(document).find('.comment-edit-button a.edit-comment').each(function(){
				$(this).fadeIn(400);
			});
			$(document).find('.post-comment').each(function(){
				$(this).fadeIn(400);
			});
		}
	});
	
	//Delete action
	$(document).on('submit','form.delete-post', function() {
		var deleteText = $(this).find('.delete').val();
		var confirmCancel = confirm(deleteText+'. Are you sure?');
		
		if(confirmCancel == true) return;
		else return false;
	});

	// active search of accounts
	var stoppedAccountSearch;
	$(document).on('input','.search-accounts', function() {
		$(this).addClass('active-accounts-search');
		if (stoppedAccountSearch) clearTimeout(stoppedAccountSearch);
		var thisTag = $(this);
		stoppedAccountSearch = setTimeout(function(thisTag){
			var accountSearch = $(document).find('.search-accounts.active-accounts-search').val();
			console.log(accountSearch);
		
			$('.search-accounts.active-accounts-search').parent().find('.accounts-search-ajax').show().html('<span><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."> Searching...</span>');
			$('.search-accounts.active-accounts-search').parent().find('.accounts-search-ajax').addClass('active-accounts-search-ajax');
			if(accountSearch.length >= 1) {
				// search accounts and return a list
				var accountSearchOptions = { 
					target:   '.accounts-search-ajax',   // target element(s) to be updated with server response 
					success:       accountSearchSuccess,  // post-submit callback
					dataType: 'json',
					data: { 
						_token: $('.search-accounts.active-accounts-search').parent().parent().parent().find('input[name=_token]').attr('value'),
						title: accountSearch
					},
					type: 'POST',
					url: '/accounts/search/'+accountSearch,
					resetForm: false        // reset the form after successful submit 
				};
				$(document).find('.changed-input').each(function() {
					$(this).removeClass('changed-input');
				});
				$(this).ajaxSubmit(accountSearchOptions);
				return false;
			}
			else $('.search-accounts.active-accounts-search').parent().find('.accounts-search-ajax').slideUp(500).html('');
		 }, 1e3);
	});
	$(document).on('mouseenter','.active-accounts-search-ajax.accounts-search-ajax span', function(){
		$(this).removeClass('search-hover');
	});
	$(document).on('click','.active-accounts-search-ajax.accounts-search-ajax span', function() {
		var accountID = parseInt($(this).attr('value'),10);
		var accountText = $(this).text();
		$(this).closest('form.add-project').find('input[name=account_name]').val(accountText);
		$(this).closest('form.add-project').find('input[name=account_id]').attr('value',accountID);
		$(document).find('form.add-project .accounts-search-ajax').hide();
		$(this).removeClass('.active-accounts-search-ajax');
		$(document).find('.search-accounts.active-accounts-search').removeClass('active-accounts-search');
	});

	function accountSearchSuccess(data)
	{
		if(data.msg == 'found some') {
			$(document).find('.active-accounts-search-ajax.accounts-search-ajax').fadeIn().html(data.accounts);
			$(document).find('.active-accounts-search-ajax.accounts-search-ajax span').first().addClass('search-hover');
		}
		else {
			$(document).find('.active-accounts-search-ajax.accounts-search-ajax').show().html('<p>No accounts found. Be sure account is added to system before continuing.</p>');
		}
	}

	// add pingable names to content textarea of form
	$.fn.extend({
		insertAtCaret: function(myValue){
		  return this.each(function(i) {
		    if (document.selection) {
		      //For browsers like Internet Explorer
		      this.focus();
		      var sel = document.selection.createRange();
		      sel.text = myValue;
		      this.focus();
		    }
		    else if (this.selectionStart || this.selectionStart == '0') {
		      //For browsers like Firefox and Webkit based
		      var startPos = this.selectionStart;
		      var endPos = this.selectionEnd;
		      var scrollTop = this.scrollTop;
		      this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
		      this.focus();
		      this.selectionStart = startPos + myValue.length;
		      this.selectionEnd = startPos + myValue.length;
		      this.scrollTop = scrollTop;
		    } else {
		      this.value += myValue;
		      this.focus();
		    }
		  });
		}
	});
	$(document).on('click', '.form-textarea-buttons .ping', function(){
		var ping = $(this).attr('id');
	    $('textarea[name=content]').insertAtCaret(ping);
	});

	// on Submit of Edit page, remove any changed-input classes.
	$(document).on('submit', '.update-something-form form', function(){
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
	});

	// add Delete option to attachments on Edit article page
	$('.update-something-form .post-edit-attachment').hover(function(){
		$(this).append('<span class="ss-delete delete-attachment"></span>');
	}, function(){
		$(this).find('.delete-attachment').remove();
	});
	// add delete option to comment attachments on edit action
	$(document).on('mouseenter', '.update-something-form .comment-edit-attachment', function(){
		$(this).append('<span class="ss-delete delete-attachment"></span>');
	});
	$(document).on('mouseleave', '.update-something-form .comment-edit-attachment', function(){
		$(this).find('.delete-attachment').remove();
	});

	// delete attachment with ajax and reload Edit article page
	$(document).on('click', '.update-something-form .edit-this-attachment', function() {
		var confirmCancel = confirm('Are you sure you want to delete this attachment?');
		
		if(confirmCancel == true) {
			var deletePath = $(this).attr('formlocation');
			var imageName = $(this).find('a img').attr('alt');
			var imagePath = $(this).find('a').attr('href');
			var imageId = $(this).parent().parent().find('form.update-something').attr('id');
			imageId = imageId.replace('edit-comment-','');
			var imageToken = $(this).parent().parent().find('form.update-something input[name=_token]').val();
			$.post(
				deletePath+'/'+imageId+'/remove/'+imageName,
				{
					"_token": imageToken,
					"imageName" : imageName,
					"imagePath" : imagePath,
					"id" : imageId,
				}, function (data) {
					if(data.errorMsg) {
						$('#message-box-json').slideDown(1000).find('.section').html('<div class="action-message"><span class="flash-message flash-message-error"><span class="ss-alert"></span>' + data.errorMsg + '</span></div>');
					}
					else {
						if(data.windowAction) {
							sessionStorage.setItem('flash_message_error', data.msg);
							window.location.href = data.windowAction;
						}
						if(data.image) {
							$('#message-box-json').slideDown(1000).find('.section').html('<div class="action-message"><span class="flash-message flash-message-error"><span class="ss-alert"></span>' + data.msg + '</span></div>');
							$(document).find('a[href="'+ data.image +'"]').slideUp(1000);
							$('#message-box-json').delay(3000).slideUp(1000);
						}
					}
				},'json'
			);
		}
	});

	//Favorite/Unfavorite an Article
	$(document).find('.favorite-this.favorited .favorite-this-text').html('Unfavorite Article');
	$(document).find('#page-nav_menu .favorite-this.favorited .favorite-this-text').html('Unfavorite');
	$(document).on('click', '.favorite-this', function(){
		var articleId = $(this).find('.favorite-this-text').attr('favoriteval');
		$.post(
			$('form#favorite-article-'+articleId).prop('action'),
			{
				"_token" : $('form#favorite-article-'+articleId).find('input[name=_token]').val(),
				"favorite" : $('form#favorite-article-'+articleId).find('input[name=favorite]').val(),
			}, function (data) {
				if(data.nofav) {
					$('#favorite-'+articleId).removeClass('favorited');
					$('#favorite-'+articleId).find('.favorite-this-text').html('Favorite Article');
					$('#page-nav_menu #favorite-'+articleId).find('.favorite-this-text').html('Favorite');
					$('#message-box-json').slideDown(1000).find('.section').html('<div class="action-message"><span class="flash-message flash-message-error"><span class="ss-halfheart"></span> <span class="ss-halfheart break-heart"></span>' + data.nofav + '</span></div>');
					$('#message-box-json').delay(5000).slideUp(1000);
				}
				else {
					$('#favorite-'+articleId).addClass('favorited');
					$('#favorite-'+articleId).find('.favorite-this-text').html('Unfavorite Article');
					$('#page-nav_menu #favorite-'+articleId).find('.favorite-this-text').html('Unfavorite');
					$('#message-box-json').slideDown(1000).find('.section').html('<div class="action-message"><span class="flash-message flash-message-success"><span class="ss-heart"></span>' + data.fav + '</span></div>');
					$('#message-box-json').delay(5000).slideUp(1000);
				}
			},'json'
		);
		return false;
	});

	/* Profile Page */
	// disabling dates
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var checkin = $('#vacation-date-start').datepicker({
      onRender: function(date) {
        return date.valueOf() < now.valueOf() ? 'disabled' : '';
      }
    }).on('changeDate', function(ev) {
      if (ev.date.valueOf() >= checkout.date.valueOf()) {
        var newDate = new Date(ev.date)
        newDate.setDate(newDate.getDate());
        checkout.setValue(newDate);
      }
      checkin.hide();
      $('#vacation-date-end')[0].focus();
    }).data('datepicker');
    var checkout = $('#vacation-date-end').datepicker({
      onRender: function(date) {
        return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
      }
    }).on('changeDate', function(ev) {
      checkout.hide();
    }).data('datepicker');

	/* Admin Page */
	// add datepicker to user edit form
	$('#admin-page form.update-user input.anniversary').datepicker();
	// add additional tasks to New Template form
	// add one
	$(document).on('click','#content form.add-template .add-task-one', function() {
		$(this).closest('.new-form-field').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
		$.get( "/admin/templates/add-task", function( data ) {
			$(document).find('#content form.add-template .add-task-buttons').before(data);
			$(document).find('#content form.add-template .loading-something-new').remove();
		});
	});
	// add five
	$(document).on('click','#content form.add-template .add-task-five', function() {
		$(this).closest('.new-form-field').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
		for (var i = 1; i <= 5; i++) {
			$.get( "/admin/templates/add-task", function( data ) {
				$(document).find('#content form.add-template .add-task-buttons').before(data);
			$(document).find('#content form.add-template .loading-something-new').remove();
			});
		};
	});
	// add ten
	$(document).on('click','#content form.add-template .add-task-ten', function() {
		$(this).closest('.new-form-field').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
		for (var i = 1; i <= 10; i++) {
			$.get( "/admin/templates/add-task", function( data ) {
				$(document).find('#content form.add-template .add-task-buttons').before(data);
			$(document).find('#content form.add-template .loading-something-new').remove();
			});
		};
	});
	// add after
	$(document).on('click','#content form.add-template .add-task', function() {
		$(this).closest('.new-form-field').after('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
		$.get( "/admin/templates/add-task", function( data ) {
			$(document).find('#content form.add-template .loading-something-new').after(data);
			$(document).find('#content form.add-template .loading-something-new').remove();
		});
	});
	// remove task from New Template form
	$(document).on('mouseover','#content form.add-template .remove-task', function() {
		$(this).closest('.new-form-field').prev().addClass('remove-this');
		$(this).closest('.new-form-field').prev().prev().addClass('remove-this');
	});
	$(document).on('mouseout','#content form.add-template .remove-task', function() {
		$(this).closest('.new-form-field').prev().removeClass('remove-this');
		$(this).closest('.new-form-field').prev().prev().removeClass('remove-this');
	});
	$(document).on('click','#content form.add-template .remove-task', function() {
		$(this).closest('.new-form-field').prev().remove();
		$(this).closest('.new-form-field').prev().remove();
		$(this).closest('.new-form-field').remove();
	});
	
	/* Tags Page */
	// Filter by letter
	$(document).on('change','#page-nav_menu .filter-letter.tags-filter', function(){
		var letterLink = $(this).val();
		window.location.href='/tags/letter/'+letterLink;
	});
	$(document).on('change','#page-nav_menu .filter-tag-type.tags-filter', function(){
		var typeLink = $(this).val();
		window.location.href='/tags/type/'+typeLink;
	});

	/* Add Tags */
	$(document).on('click','.tag-addnew', function() {
		$(this).removeClass('ss-plus').addClass('ss-delete').addClass('active');
		$(document).find('.addnew-tag').addClass('add-new-tag-input').fadeIn(800).focus();

// 		var stoppedTyping;
// $('#input').on('keypress', function(){
//   // is there already a timer? clear if if there is
//   if (stoppedTyping) clearTimeout(stoppedTyping);
//   // set a new timer to execute 3 seconds from last keypress
//   stoppedTyping = setTimeout(function(){
//     // code to trigger once timeout has elapsed
//   }, 1e3); // 3 seconds
// });
		var stoppedTyping;
		$(document).on('keypress','form.add-new-tag .addnew-tag', function() {
			if (stoppedTyping) clearTimeout(stoppedTyping);
			var thisTag = $(this);
			stoppedTyping = setTimeout(function(thisTag){
				var tagsSearch = $(document).find('form.add-new-tag .addnew-tag').val();
				console.log(tagsSearch);
				$(document).find('form.add-new-tag .tags-search-ajax').show().html('<span><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."> Searching...</span>');
				if(tagsSearch.length >= 1) {
					// search tags and return a list
					var tagsSearchOptions = { 
						target:   '.tags-search-ajax',   // target element(s) to be updated with server response 
						success:       tagsSearchSuccess,  // post-submit callback
						dataType: 'json',
						data: { 
							_token: $(document).find('form.add-new-tag input[name=_token]').attr('value'),
							title: tagsSearch
						},
						type: 'POST',
						url: '/tags/search/'+tagsSearch,
						resetForm: false        // reset the form after successful submit 
					};
					$(this).find('.changed-input').each(function() {
						$(this).removeClass('changed-input');
					});
					$(this).ajaxSubmit(tagsSearchOptions);
					return false;
				}
			 }, 1e3);
		});
		$(document).on('mouseenter','form.add-new-tag .tags-search-ajax span', function(){
			$(this).removeClass('search-hover');
		});
		
		$(document).on('click','form.add-new-tag .tags-search-ajax span.tags-searched', function() {
			var existingTagsID = $(this).closest('form.add-new-tag').find('input[name=tag_id]').attr('value');
			//console.log(existingTagsID);
			var tagsID = parseInt($(this).attr('value'),10);
			var tagsText = $(this).text();
			$(this).closest('form.add-new-tag').find('.tags-added-ajax').append('<span class="tag-added tag-name"><a class="ss-tag">'+tagsText+'</a></span>');
			if(existingTagsID == null) $(this).closest('form.add-new-tag').find('input[name=tag_id]').attr('value',tagsID);
			else $(this).closest('form.add-new-tag').find('input[name=tag_id]').attr('value',existingTagsID+','+tagsID);
			$(document).find('form.add-new-tag .tags-search-ajax').hide();
			$(this).closest('form.add-new-tag').find('input[name=tag_name]').val('');
			$(this).closest('form.add-new-tag').find('.changed-input').each(function() {
				$(this).removeClass('changed-input');
			});
		});
		// $(document).on('click','form.add-vault-asset .tags-search-ajax span.tag-addnew', function() {
		// 	var tagsNewText = $(this).text();
		// 	var tagsAddNewOptions = { 
		// 		target:   '.tags-added-ajax',   // target element(s) to be updated with server response 
		// 		success:       tagsAddNewSuccess,  // post-submit callback
		// 		dataType: 'json',
		// 		data: { 
		// 			_token: $(this).parent().parent().parent().parent().find('input[name=_token]').attr('value')
		// 		},
		// 		type: 'POST',
		// 		url: '/tags/newtag/'+tagsNewText,
		// 		resetForm: false        // reset the form after successful submit 
		// 	};
		// 	$(this).find('.changed-input').each(function() {
		// 		$(this).removeClass('changed-input');
		// 	});
		// 	$(this).ajaxSubmit(tagsAddNewOptions);
		// 	return false;
		// });
		$(document).on('click','form.add-new-tag .tags-search-ajax p', function() {
			$(document).find('form.add-new-tag .tags-search-ajax').hide();
		});
	});
	$(document).on('click','.tag-addnew.active', function() {
		$(this).removeClass('ss-delete').addClass('ss-plus').removeClass('active');		
		$(document).find('.addnew-tag').fadeOut(800);
		$(document).find('form.add-new-tag .tags-search-ajax').hide();
		$(document).find('form.add-new-tag').find('input[name=tag_name]').val('');
	});
	// function tagsAddNewSuccess(data)
	// {
	// 	if(data.errorMsg) {
	// 		$('#message-box-json').fadeIn();
	// 		$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
	// 	}
	// 	else {
	// 		$('#message-box-json').fadeIn();
	// 		$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-success">'+data.msg+'</span></div>');
	// 		var existingTagsID = $(document).find('form.add-vault-asset input[name=tag_id]').attr('value');
	// 		//console.log(existingTagsID);
	// 		var tagNewID = data.tagID;
	// 		var tagNewText = data.tagname;
	// 		$(document).find('form.add-vault-asset .tags-added-ajax').append('<span class="tag-added tag-name"><a class="ss-tag">'+tagNewText+'</a></span>');
	// 		if(existingTagsID == null) $(document).find('form.add-vault-asset input[name=tag_id]').attr('value',tagNewID);
	// 		else $(document).find('form.add-vault-asset input[name=tag_id]').attr('value',existingTagsID+','+tagNewID);
	// 		$(document).find('form.add-vault-asset .tags-search-ajax').hide();
	// 		$(document).find('form.add-vault-asset input[name=tag_name]').val('');
	// 		$(document).find('form.add-vault-asset .changed-input').each(function() {
	// 				$(this).removeClass('changed-input');
	// 			});
	// 		$('#message-box-json').delay(4000).fadeOut();
	// 		//.find('.section').empty();
	// 	}
	// }
	function tagsSearchSuccess(data)
	{
		if(data.msg == 'found some') {
			console.log('found some');
			$(document).find('form.add-new-tag .tags-search-ajax').show().html(data.tagsSearch);
			$(document).find('form.add-new-tag .tags-search-ajax span').first().addClass('search-hover');
		}
		else {
			$(document).find('form.add-new-tag .tags-search-ajax').show().html('<p>No existing tags found matching the search criteria. [x]</p><p>Create Tag: </p><span value="'+data.tagsSearch+'" class="tag-addnew tag-name"><a class="ss-tag">'+data.tagsSearch+'</a></span>');
		}
	}

	/* News Page */
	// filter by type (unread, mentions, favorites, drafts)
	$(document).on('change','#page-nav_menu .filter-type.news-filter', function(){
		var typeLink = $(this).val();
		if(typeLink == 0 || typeLink == '0') window.location.href='/news';
		else window.location.href='/news/'+typeLink;
	});
	// Filter by author
	$(document).on('change','#page-nav_menu .filter-author.news-filter', function(){
		var authorLink = $(this).val();
		window.location.href='/news/author/'+authorLink;
	});
	// Filter by date
	$('#page-nav_menu .page-menu div.filter-date.news-filter').datepicker().on('changeDate', function(ev) {
		$('.dropdown-menu').hide();
		var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
		var dateLink = new Date(ev.date.valueOf());
		var yearLink = dateLink.getFullYear();
		var monthLink = months[dateLink.getMonth()];
		window.location.href='/news/date/'+yearLink+'/'+monthLink;
	});
	// Show/hide preview of content on article hover
	// do this different
	// $('#content .office-post').hover(function() {
	// 	$(this).find('.post-hover-content').show();
	// }, function() {
	// 	$(this).find('.post-hover-content').hide();
	// });
	// detect Status change and update submit button text
	$(document).on('change', 'form.add-article select[name=status]', function(){
		var selectVal = $(this).val();
		var submitText = $(this).find('option[value='+selectVal+']').text();
		$('form.add-article').find('input#add-new-submit').val(submitText);
	});
	// add post to calendar functionality to Edit article page
	var calTemp = new Date();
	var calNow = new Date(calTemp.getFullYear(), calTemp.getMonth(), calTemp.getDate(), 0, 0, 0, 0);
	var calPost = $('#news-page form.update-article .article-calendar-date').datepicker({
		onRender: function(date) {
			return date.valueOf() < calNow.valueOf() ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
	   	calPost.hide();
	   	$(this).addClass('changed-input');
	}).data('datepicker');
	
	/* Calendar Page */
	$('#page-nav_menu div.calendar-jump-to-date.calendar-filter').datepicker().on('changeDate', function(ev) {
		$('.dropdown-menu').hide();
		var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
		var dateLink = new Date(ev.date.valueOf());
		var yearLink = dateLink.getFullYear();
		var monthLink = months[dateLink.getMonth()];
		window.location.href='/calendar/'+yearLink+'/'+monthLink;
	});
	$(document).on('change', '#page-nav_menu .show-hide-calendar', function() {
		var toggleThis = $(this).val();
		$('#calendar-page').find('.'+toggleThis).toggle();
		if(toggleThis == 'show-all') $('#calendar-page').find('.calendar-post-title').show();
		if(toggleThis == 'hide-all') $('#calendar-page').find('.calendar-post-title').hide();
	});
	var calendarPageHeight = $(window).height();
	calendarPageHeight = calendarPageHeight-172;
	$(document).find('#content #calendar-page .days-of-month').css('height',calendarPageHeight+'px');
	
	/* Projects Page */
	// Filter by user
	$(document).on('change','#page-nav_menu .filter-user.projects-filter', function(){
		var authorLink = $(this).val();
		window.location.href='/projects/assigned-to/'+authorLink;
	});
	// Filter by project stage
	$(document).on('change','#page-nav_menu .filter-stage.projects-filter', function(){
		var stageLink = $(this).val();
		var typeLink = $(this).next().val();
		window.location.href='/projects/type/'+typeLink+'/stage/'+stageLink;
	});
	// Filter by project priority
	$(document).on('change','#page-nav_menu .filter-priority.projects-filter', function(){
		var priorityLink = $(this).val();
		window.location.href='/projects/priority/'+priorityLink;
	});
	// Filter by project status
	$(document).on('change','#page-nav_menu .filter-status.projects-filter', function(){
		var statusLink = $(this).val();
		window.location.href='/projects/status/'+statusLink;
	});
	// Filter by project type
	$(document).on('change','#page-nav_menu .filter-type.projects-filter', function(){
		var typeLink = $(this).val();
		window.location.href='/projects/type/'+typeLink;
	});
	// Filter by date
	$('#page-nav_menu .page-menu div.filter-date.projects-filter').datepicker().on('changeDate', function(ev) {
		$('.dropdown-menu').hide();
		var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
		var dateLink = new Date(ev.date.valueOf());
		var yearLink = dateLink.getFullYear();
		var monthLink = months[dateLink.getMonth()];
		window.location.href='/projects/date/'+yearLink+'/'+monthLink;
	});
	// Bump Project on List View 1 day with ajax
	$(document).on('click', '#content .office-post .post-due-bump-date', function() {
			var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
			
			var dateLink = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
			var yearLink = dateLink.getFullYear();
			var monthLink = dateLink.getMonth();
			monthLink = ('0' + (monthLink + 1)).slice(-2);
			var dayLink = dateLink.getDate();
			dayLink = ('0' + (dayLink)).slice(-2);
			// set project post date ajax submit options
			var bumpProjectDateOptions = { 
				target:   '#message-box-json .section',   // target element(s) to be updated with server response 
				success:       projectDateBumpSuccess,  // post-submit callback
				dataType: 'json',
				data: { 
					_token: $(this).parent().parent().find('form.bump-project-date-form input[name=_token]').attr('value'),
					id: $(this).parent().parent().find('form.bump-project-date-form input[name=id]').attr('value'),
					value: monthLink+'/'+dayLink+'/'+yearLink,
					date: 'youbetcha',
				},
				type: 'POST',
				url: $(this).parent().parent().find('form.bump-project-date-form').attr('action'),
				resetForm: false        // reset the form after successful submit 
			};
			$(this).find('.changed-input').each(function() {
				$(this).removeClass('changed-input');
			});
			$(this).ajaxSubmit(bumpProjectDateOptions);
			return false;
	});
	function projectDateBumpSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			var projectID = data.pid;
			$(document).find('div#project-'+projectID+' .post-due .post-due-date').html('<span class="post-due-date">'+data.date+'</span>');
			$(document).find('div#project-'+projectID+' .post-date .change-project-date').html('Due Date: <br /><span class="post-due-date">'+data.date+'</span><span class="project-change-date ss-calendar"></span>');
			$(document).find('div#project-'+projectID).addClass('due-soon');
			$(document).find('div#project-'+projectID).removeClass('due-now');
			$(document).find('div#project-'+projectID+' .post-alert').remove();
			$(document).find('div#project-'+projectID).addClass(data.changeclass);
		}
	}
	// Update Projects on List View page with ajax
	// change project date
	var calProjListTemp = new Date();
	var calProjListNow = new Date(calProjListTemp.getFullYear(), calProjListTemp.getMonth(), calProjListTemp.getDate(), 0, 0, 0, 0);
	var calProjListPost = $('#content .change-project-date').datepicker({
		onRender: function(date) {
			return date.valueOf() < calProjListNow.valueOf() ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
	   	calProjListPost.hide();
	   	$('.dropdown-menu').hide();
	   		var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
			
			var dateLink = new Date(ev.date.valueOf());
			var yearLink = dateLink.getFullYear();
			var monthLink = dateLink.getMonth();
			monthLink = ('0' + (monthLink + 1)).slice(-2);
			var dayLink = dateLink.getDate();
			dayLink = ('0' + (dayLink)).slice(-2);
			// set project post date ajax submit options
			var changeProjectDateOptions = { 
				target:   '#message-box-json .section',   // target element(s) to be updated with server response 
				success:       projectDateChangeSuccess,  // post-submit callback
				dataType: 'json',
				data: { 
					_token: $(this).parent().parent().find('form.change-project-date-form input[name=_token]').attr('value'),
					id: $(this).parent().parent().find('form.change-project-date-form input[name=id]').attr('value'),
					value: monthLink+'/'+dayLink+'/'+yearLink,
					date: 'youbetcha',
				},
				type: 'POST',
				url: $(this).parent().parent().find('form.change-project-date-form').attr('action'),
				resetForm: false        // reset the form after successful submit 
			};
			$(this).find('.changed-input').each(function() {
				$(this).removeClass('changed-input');
			});
			$(this).ajaxSubmit(changeProjectDateOptions);
			return false;
	}).data('datepicker');
	// $('#content .change-project-date').datepicker().on('changeDate', function(ev) {
	// 	$('.dropdown-menu').hide();
	// 	var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
		
	// 	var dateLink = new Date(ev.date.valueOf());
	// 	var yearLink = dateLink.getFullYear();
	// 	var monthLink = dateLink.getMonth();
	// 	monthLink = monthLink+1;
	// 	var dayLink = dateLink.getDate();
		
	// 	// set project post date ajax submit options
	// 	var changeProjectDateOptions = { 
	// 		target:   '#message-box-json .section',   // target element(s) to be updated with server response 
	// 		success:       projectDateChangeSuccess,  // post-submit callback
	// 		dataType: 'json',
	// 		data: { 
	// 			_token: $(this).parent().find('form.change-project-date-form input[name=_token]').attr('value'),
	// 			id: $(this).parent().find('form.change-project-date-form input[name=id]').attr('value'),
	// 			value: yearLink+'-'+monthLink+'-'+dayLink,
	// 			date: 'youbetcha',
	// 		},
	// 		type: 'POST',
	// 		url: $(this).parent().find('form.change-project-date-form').attr('action'),
	// 		resetForm: false        // reset the form after successful submit 
	// 	};
	// 	$(this).find('.changed-input').each(function() {
	// 		$(this).removeClass('changed-input');
	// 	});
	// 	$(this).ajaxSubmit(changeProjectDateOptions);
	// 	return false;
	// });

	function projectDateChangeSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			var projectID = data.pid;
			$(document).find('div#project-'+projectID+' .post-date .change-project-date').html('<span class="tooltip">Change<br />Due Date</span>Due Date: <br /><span class="post-due-date">'+data.date+'</span><span class="project-change-date ss-calendar"></span>');
			$(document).find('div#project-'+projectID+' .project-stage-due-date .change-project-date .project-due-date-text ').html('<span class="tooltip">Change<br />Due Date</span><span class="post-due-date">'+data.date+'</span>');
			$(document).find('div#project-'+projectID).removeClass('due-soon');
			$(document).find('div#project-'+projectID).removeClass('due-now');
			$(document).find('div#project-'+projectID+' .post-due-text-alert').remove();
			$(document).find('div#project-'+projectID).addClass(data.changeclass);
		}
	}
	// change project launch date on single view page
	var calProjLaunchTemp = new Date();
	var calProjLaunchNow = new Date(calProjLaunchTemp.getFullYear(), calProjLaunchTemp.getMonth(), calProjLaunchTemp.getDate(), 0, 0, 0, 0);
	var calProjLaunchPost = $('#content .change-project-launch-date').datepicker({
		onRender: function(date) {
			return date.valueOf() < calProjLaunchNow.valueOf() ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
	   	//calProjLaunchPost.hide();
	   	$('.dropdown-menu').hide();
	   		var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
			
			var dateLink = new Date(ev.date.valueOf());
			var yearLink = dateLink.getFullYear();
			var monthLink = dateLink.getMonth();
			monthLink = ('0' + (monthLink + 1)).slice(-2);
			var dayLink = dateLink.getDate();
			dayLink = ('0' + (dayLink)).slice(-2);
			// set project post date ajax submit options
			var changeProjectLaunchDateOptions = { 
				target:   '#message-box-json .section',   // target element(s) to be updated with server response 
				success:       projectLaunchChangeSuccess,  // post-submit callback
				dataType: 'json',
				data: { 
					_token: $(this).parent().parent().find('form.change-project-launch-date-form input[name=_token]').attr('value'),
					id: $(this).parent().parent().find('form.change-project-launch-date-form input[name=id]').attr('value'),
					value: monthLink+'/'+dayLink+'/'+yearLink,
					date: 'changelaunch',
				},
				type: 'POST',
				url: $(this).parent().parent().find('form.change-project-launch-date-form').attr('action'),
				resetForm: false        // reset the form after successful submit 
			};
			$(this).find('.changed-input').each(function() {
				$(this).removeClass('changed-input');
			});
			$(this).ajaxSubmit(changeProjectLaunchDateOptions);
			return false;
	}).data('datepicker');
	function projectLaunchChangeSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			var projectID = data.pid;
			$(document).find('div#project-'+projectID+' .project-stage-due-date .change-project-launch-date .project-launch-date-text').html('<span class="tooltip">Change<br />Launch</span><span class="post-launch-date"> '+data.date+'</span>');
		}
	}
	//subscribe to project notifications
	$(document).on('click', '#content .project-post .subscribe-to', function(){
		var projectId = $(this).attr('subscribeval');
		//console.log(projectId);

		// set project user ajax submit options
		var changeYourProjectSubOptions = { 
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       projectYourSubChangeSuccess,  // post-submit callback
			dataType: 'json',
			data: { 
				_token: $(this).parent().find('form.subscribe-to-project-form input[name=_token]').attr('value'),
				id: $(this).parent().find('form.subscribe-to-project-form input[name=id]').attr('value'),
				value: projectId,
				thisPage: window.location.pathname,
				subscribeTo: 'updatesub',
			},
			type: 'POST',
			url: $(this).parent().find('form.subscribe-to-project-form').attr('action'),
			resetForm: false        // reset the form after successful submit 
		};
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
		$(this).ajaxSubmit(changeYourProjectSubOptions);
		return false;
	});

	function projectYourSubChangeSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			$(document).find('.post-subscribed #subscribe-'+data.pid).addClass('subscribed-to');
			$(document).find('.post-subscribed #subscribe-'+data.pid).html('<span class="tooltip">Subscribed<br />to Project</span>');
		}
	}
	//change project user
	$(document).on('change', '#content .office-post .change-project-user-list', function() {
		var userSelect = $(this).val();
		//console.log(userSelect);

		// set project user ajax submit options
		var changeProjectUserOptions = { 
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       projectUserChangeSuccess,  // post-submit callback
			dataType: 'json',
			data: { 
				_token: $(this).parent().parent().find('form.change-project-user-form input[name=_token]').attr('value'),
				id: $(this).parent().parent().find('form.change-project-user-form input[name=id]').attr('value'),
				value: userSelect,
				thisPage: window.location.pathname,
				user: 'userchange',
			},
			type: 'POST',
			url: $(this).parent().parent().find('form.change-project-user-form').attr('action'),
			resetForm: false        // reset the form after successful submit 
		};
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
		$(this).ajaxSubmit(changeProjectUserOptions);
		return false;
	});

	function projectUserChangeSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			var projectID = data.pid;
			window.location.href = data.thispage;
		}
	}
	//change project stage
	$(document).on('change', '#content .office-post .change-project-stage-list', function() {
		var stageSelect = $(this).val();
		//console.log(userSelect);

		// set project user ajax submit options
		var changeProjectStageOptions = { 
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       projectStageChangeSuccess,  // post-submit callback
			dataType: 'json',
			data: { 
				_token: $(this).parent().parent().find('form.change-project-stage-form input[name=_token]').attr('value'),
				id: $(this).parent().parent().find('form.change-project-stage-form input[name=id]').attr('value'),
				value: stageSelect,
				thisPage: window.location.pathname,
				stage: 'stagechange',
			},
			type: 'POST',
			url: $(this).parent().parent().find('form.change-project-stage-form').attr('action'),
			resetForm: false        // reset the form after successful submit 
		};
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
		$(this).ajaxSubmit(changeProjectStageOptions);
		return false;
	});

	function projectStageChangeSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			var projectID = data.pid;
			window.location.href = data.thispage;
		}
	}
	// Projects Single View updating via ajax
	//change project manager
	$(document).on('change', '#content .office-post-single .change-project-manager-list', function() {
		var userSelect = $(this).val();
		//console.log($(this).parent().find('form.change-project-user-form input[name=_token]').attr('value'));

		// set project manager ajax submit options
		var changeSingleProjectManagerOptions = { 
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       singleProjectManagerChangeSuccess,  // post-submit callback
			dataType: 'json',
			data: { 
				_token: $(this).parent().parent().find('form.change-project-manager-form input[name=_token]').attr('value'),
				id: $(this).parent().parent().find('form.change-project-manager-form input[name=id]').attr('value'),
				value: userSelect,
				thisPage: window.location.pathname,
				user: 'managerchange',
			},
			type: 'POST',
			url: $(this).parent().parent().find('form.change-project-manager-form').attr('action'),
			resetForm: false        // reset the form after successful submit 
		};
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
		$(this).ajaxSubmit(changeSingleProjectManagerOptions);
		return false;
	});

	function singleProjectManagerChangeSuccess(data)
	{
		var projectID = data.pid;
		window.location.href = data.thispage;	
	}
	//change project user
	$(document).on('change', '#content .office-post-single .change-project-user-list', function() {
		var userSelect = $(this).val();
		//console.log($(this).parent().find('form.change-project-user-form input[name=_token]').attr('value'));

		// set project user ajax submit options
		var changeSingleProjectUserOptions = { 
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       singleProjectUserChangeSuccess,  // post-submit callback
			dataType: 'json',
			data: { 
				_token: $(this).parent().parent().find('form.change-project-user-form input[name=_token]').attr('value'),
				id: $(this).parent().parent().find('form.change-project-user-form input[name=id]').attr('value'),
				value: userSelect,
				thisPage: window.location.pathname,
				user: 'userchange',
			},
			type: 'POST',
			url: $(this).parent().parent().find('form.change-project-user-form').attr('action'),
			resetForm: false        // reset the form after successful submit 
		};
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
		$(this).ajaxSubmit(changeSingleProjectUserOptions);
		return false;
	});

	function singleProjectUserChangeSuccess(data)
	{
		var projectID = data.pid;
		window.location.href = data.thispage;	
	}
	//change project priority
	$(document).on('change', '#content .office-post-single select[name=change-project-priority]', function() {
		var stageSelect = $(this).val();
		//console.log($(this).parent().find('form.change-project-user-form input[name=_token]').attr('value'));

		// set project priority ajax submit options
		var changeSingleProjectStageOptions = { 
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       singleProjectStageChangeSuccess,  // post-submit callback
			dataType: 'json',
			data: { 
				_token: $(this).parent().parent().find('form.change-project-priority-form input[name=_token]').attr('value'),
				id: $(this).parent().parent().find('form.change-project-priority-form input[name=id]').attr('value'),
				value: stageSelect,
				thisPage: window.location.pathname,
				priority: 'prioritychange',
			},
			type: 'POST',
			url: $(this).parent().parent().find('form.change-project-priority-form').attr('action'),
			resetForm: false        // reset the form after successful submit 
		};
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
		$(this).ajaxSubmit(changeSingleProjectStageOptions);
		return false;
	});

	function singleProjectStageChangeSuccess(data)
	{
		var projectID = data.pid;
		window.location.href = data.thispage;	
	}
	//change project subscribed
	$(document).on('click', '#content .post-subscribed .ss-delete', function() {
		var userSelect = $(this).attr('value');
		//console.log(userSelect);

		// set project user ajax submit options
		var changeProjectSubOptions = { 
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       projectSubChangeSuccess,  // post-submit callback
			dataType: 'json',
			data: { 
				_token: $(this).parent().find('form.change-project-sub-form input[name=_token]').attr('value'),
				id: $(this).parent().find('form.change-project-sub-form input[name=id]').attr('value'),
				value: userSelect,
				thisPage: window.location.pathname,
				subRemove: 'subremove',
			},
			type: 'POST',
			url: $(this).parent().find('form.change-project-sub-form').attr('action'),
			resetForm: false        // reset the form after successful submit 
		};
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
		$(this).ajaxSubmit(changeProjectSubOptions);
		return false;
	});

	function projectSubChangeSuccess(data)
	{
		var projectID = data.pid;
		$(document).find('div#project-'+projectID+' .post-subscribed div[value='+data.sub+']').remove();	
	}
	//add project subscribed
	$(document).on('click','#content .post-subscribed div.ss-plus', function(){
		$(this).next().toggle();
	});
	$(document).on('change', '#content .post-subscribed .select-dropdown select[name=add-project-sub-list]', function() {
		var userSelect = $(this).val();
		//console.log(userSelect);

		// set project user ajax submit options
		var addProjectSubOptions = { 
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       projectSubAddSuccess,  // post-submit callback
			dataType: 'json',
			data: { 
				_token: $(this).parent().parent().parent().find('form.change-project-sub-form input[name=_token]').attr('value'),
				id: $(this).parent().parent().parent().find('form.change-project-sub-form input[name=id]').attr('value'),
				value: userSelect,
				thisPage: window.location.pathname,
				subAdd: 'subadd',
			},
			type: 'POST',
			url: $(this).parent().parent().parent().find('form.change-project-sub-form').attr('action'),
			resetForm: false        // reset the form after successful submit 
		};
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
		$(this).ajaxSubmit(addProjectSubOptions);
		return false;
	});

	function projectSubAddSuccess(data)
	{
		var projectID = data.pid;
		if(data.subName != '') {
			$(document).find('div#project-'+projectID+' .post-subscribed .user-subscribed').last().before('<div class="user-subscribed ss-delete" value="'+data.sub+'">'+data.subName+'</div>');
		}
	}
	// update checklist progress on single view page.
	$(document).find('.checklist-section').each(function(){
		var sectionTotal = parseInt($(this).find('h4.checklist-header .header-task-total').text(),10);
		//console.log(sectionTotal);
		$(this).find('input[type=checkbox]').each(function(){
				//console.log(sectionTotal);
			var openCheckbox = $(this).is(':checked');
			if(openCheckbox == false) {
				sectionTotal--;
				$(this).closest('.checklist-section').find('h4 span.header-task-complete').html(sectionTotal);
			}
			else $(this).closest('.checklist-section').find('h4 span.header-task-complete').html(sectionTotal);
			//console.log(openCheckbox);

		});
	});
	
	// Update checklist items on single view page.
	$(document).find('h4.section-disabled').each(function(){
		$(this).parent().find('input').prop('disabled', true);
		$(this).parent().find('.checklist-skip-task').prop('disabled', true);
	});
	$(document).find('input[checklist-status=open]').prop('disabled', true);
	$(document).find('input[checklist-status=open]').next().next().prop('disabled', true);
	$(document).find('input[checklist-status=open]').first().prop('disabled', false);
	$(document).find('input[checklist-status=open]').first().next().next().prop('disabled', false);
	$(document).find('h4.section-complete').each(function(){
		$(this).parent().find('.checklist-checkbox-section').hide();
	});
	$(document).on('click','h4.checklist-header',function(){
		$(this).parent().find('.checklist-checkbox-section').toggle();
		$(this).toggleClass('ss-dropdown');
		$(this).toggleClass('ss-directright');
	});
	$(document).on('change','#content .office-post-single .checklist-box input[type=checkbox]', function() {
		//console.log('clicked');
		$('#message-box-json').fadeOut();
		var userFinishedName = $(document).find('form.change-project-checkboxes-form input[name=user_finished_name]').val();
		var userFinishedDate = $(document).find('form.change-project-checkboxes-form input[name=user_finished_date]').val();
		$(this).addClass('user-checked');
		var checkboxID = $(this).val();
		var checkboxPageID = parseInt($(this).attr('checklist-number'));
		var checkboxCheck = $(this);

		var totalCheckboxes = parseInt($(document).find('.checklist-box').attr('total-checkboxes'),10);
		var progressComplete = parseInt($(document).find('#page-nav_menu .post-progress-complete').text(),10);
		//var doneProgressWidth = 200/totalCheckboxes;
		//var divProgressWidth = $(document).find('#page-nav_menu .post-progress .post-progress-progress').width();
		var saveTask = '';
		$(this).removeClass('changed-input');
		if (checkboxCheck.is(':checked'))
		{
			//$(document).find('#page-nav_menu .post-progress .post-progress-progress-zero').first().remove();
			//$(document).find('#page-nav_menu .post-progress-progress').append('<span class="post-progress-progress-done"></span>');
			$(document).find('#page-nav_menu .post-progress-complete').html(progressComplete+1);
			//$(document).find('#page-nav_menu .post-progress .post-progress-progress-done').css('width',doneProgressWidth+'px');
			//$(document).find('#page-nav_menu .post-progress .post-progress-progress').css('width',divProgressWidth+doneProgressWidth+'px');
			var sectionTotalUpdate = parseInt($(this).closest('.checklist-section').find('h4 span.header-task-complete').text(),10);
			sectionTotalUpdate++;
			$(this).closest('.checklist-section').find('h4 span.header-task-complete').html(sectionTotalUpdate);
			var checkboxValue = 'closed';
			$(this).next().append('<span class="checkbox-user-action">'+userFinishedName+' - '+userFinishedDate+'</span>');
			var nextCheckboxPageID = checkboxPageID+1;
			if($(this).parent().parent().parent().find('input[checklist-number='+nextCheckboxPageID+']').is(':checked')) {
				$(this).parent().parent().parent().find('input[checklist-number='+nextCheckboxPageID+']').prop('disabled', false).removeClass('disabled');
				var nextCheckboxPageID = checkboxPageID+2;
			}
			$(document).find('button[checklist-number='+checkboxPageID+']').remove();
			$(this).parent().parent().parent().find('input[checklist-number='+nextCheckboxPageID+']').prop('disabled', false).removeClass('disabled');
			$(this).parent().parent().parent().find('button[checklist-number='+nextCheckboxPageID+']').prop('disabled', false).removeClass('disabled');
			$(this).parent().parent().parent().find('input[checklist-number='+nextCheckboxPageID+']').closest('.checklist-section').find('h4').removeClass('section-disabled');
			if($(this).parent().next('.checklist-checkbox-section').length == 0) {
				var nextProjectStage = $(this).parent().parent().parent().find('input[checklist-number='+nextCheckboxPageID+']').parent().parent().find('.checklist-header .checklist-stage').text();
				if(nextProjectStage == '') {
					projectDone = 'closed';
					$(document).find('.project-stage-due-date .project-stage').html(projectDone);
				}
				else $(document).find('.project-stage-due-date .project-stage').html(nextProjectStage);
				$(this).parent().parent().find('h4.checklist-header').addClass('section-complete').removeClass('ss-dropdown').addClass('ss-directright');
				$(this).parent().parent().find('.checklist-checkbox-section').hide();
			}
			else {
				nextProjectStage = '';
			}
			saveTask = 'saveTask';
		}
		else {
			var confirmCancel = confirm('Are you sure you want to uncheck this task?');
			if(confirmCancel == true) {

				// $(document).find('#page-nav_menu .post-progress .post-progress-progress-done').first().remove();
				$(document).find('#page-nav_menu .post-progress-complete').html(progressComplete-1);
				//$(document).find('#page-nav_menu .post-progress .post-progress-progress').css('width',divProgressWidth-doneProgressWidth+'px');
				$(this).next().find('.checkbox-user-action').remove();
				var checkboxValue = 'open';
				var sectionTotalUpdate = parseInt($(this).closest('.checklist-section').find('h4 span.header-task-complete').text(),10);
				sectionTotalUpdate--;
				$(this).closest('.checklist-section').find('h4 span.header-task-complete').html(sectionTotalUpdate);
				$(this).parent().parent().next('.checklist-section').find('input[type=checkbox]').each(function(){
					$(this).prop('disabled', true).addClass('disabled');
				});
				$(this).parent().parent().next('.checklist-section').find('.checklist-header').addClass('section-disabled');
				
				if($(document).find('button#project-skip-task-'+checkboxID).length == 0) {
					$(this).parent().append('<button class="checklist-skip-task form-button" id="project-skip-task-'+checkboxID+'" checklist-number="'+checkboxPageID+'" task-id="'+checkboxID+'">Skip</button>');
				}
				if($(this).parent().next('.checklist-checkbox-section').length == 0) {
					var nextProjectStage = $(document).find('input[checklist-number='+checkboxPageID+']').parent().parent().find('.checklist-header .checklist-stage').text();
					//console.log(nextProjectStage);
					if(nextProjectStage == '') {
						nextProjectStage = $(document).find('.project-stage-due-date .project-stage').text();
						$(document).find('.project-stage-due-date .project-stage').html(nextProjectStage);
					}
					else $(document).find('.project-stage-due-date .project-stage').html(nextProjectStage);
					$(this).parent().parent().find('h4.checklist-header').removeClass('section-complete').addClass('ss-dropdown').removeClass('ss-directright');
				}
				else {
					nextProjectStage = $(document).find('.project-stage-due-date .project-stage').text();
				}

				saveTask = 'saveTask';
			}
			else {
				$(this).prop('checked',true);
				saveTask = '';
			}
		}
		if(saveTask == 'saveTask') {
			var changeProjectCheckboxesOptions = { 
				target:   '#message-box-json .section',   // target element(s) to be updated with server response 
				success:       changeProjectCheckboxesSuccess,  // post-submit callback
				dataType: 'json',
				data: { 
					_token: $(this).closest('form.change-project-checkboxes-form').find('input[name=_token]').attr('value'),
					id: $(this).closest('form.change-project-checkboxes-form').find('input[name=id]').attr('value'),
					value: checkboxID,
					checkboxValue: checkboxValue,
					user_finished_id: $(this).closest('form.change-project-checkboxes-form').find('input[name=user_finished_id]').attr('value'),
					thisPage: window.location.pathname,
					updatecheckbox: 'updatecheckbox',
					nextProjectStage: nextProjectStage,
				},
				type: 'POST',
				url: $(this).closest('form.change-project-checkboxes-form').attr('action'),
				resetForm: false        // reset the form after successful submit 
			};

			$(this).removeClass('changed-input');
			$(this).ajaxSubmit(changeProjectCheckboxesOptions);
			return false;
		}
		else {
			$(this).removeClass('changed-input');
			return false;
		}
	});
	$(document).on('click','#content .office-post-single .checklist-box .checklist-skip-task', function() {
		//console.log('clicked');
		$('#message-box-json').fadeOut();
		var userFinishedName = $(document).find('form.change-project-checkboxes-form input[name=user_finished_name]').val();
		var userFinishedDate = $(document).find('form.change-project-checkboxes-form input[name=user_finished_date]').val();
		$(this).parent().find('.checklist-checkbox').addClass('user-checked').attr('checked','checked');
		var checkboxID = $(this).attr('task-id');
		var checkboxPageID = parseInt($(this).attr('checklist-number'));

		var totalCheckboxes = parseInt($(document).find('.checklist-box').attr('total-checkboxes'),10);
		var progressComplete = parseInt($(document).find('#page-nav_menu .post-progress-complete').text(),10);
		//var doneProgressWidth = 200/totalCheckboxes;
		//var divProgressWidth = $(document).find('#page-nav_menu .post-progress .post-progress-progress').width();
		$(this).removeClass('changed-input');

		// $(document).find('#page-nav_menu .post-progress .post-progress-progress-zero').first().remove();
		// $(document).find('#page-nav_menu .post-progress-progress').append('<span class="post-progress-progress-done"></span>');
		$(document).find('#page-nav_menu .post-progress-complete').html(progressComplete+1);
		//$(document).find('#page-nav_menu .post-progress .post-progress-progress-done').css('width',doneProgressWidth+'px');
		//$(document).find('#page-nav_menu .post-progress .post-progress-progress').css('width',divProgressWidth+doneProgressWidth+'px');
		var sectionTotalUpdate = parseInt($(this).closest('.checklist-section').find('h4 span.header-task-complete').text(),10);
		sectionTotalUpdate++;
		$(this).closest('.checklist-section').find('h4 span.header-task-complete').html(sectionTotalUpdate);
		var checkboxValue = 'closed';
		$(this).prev().append('<span class="checkbox-user-action"><span class="this-task-skipped">(skipped)</span> '+userFinishedName+' - '+userFinishedDate+'</span>');
		var nextCheckboxPageID = checkboxPageID+1;
		if($(this).parent().parent().parent().find('input[checklist-number='+nextCheckboxPageID+']').is(':checked')) {
			$(this).parent().parent().parent().find('input[checklist-number='+nextCheckboxPageID+']').prop('disabled', false).removeClass('disabled');
			var nextCheckboxPageID = checkboxPageID+2;
		}
		$(this).parent().parent().parent().find('input[checklist-number='+nextCheckboxPageID+']').prop('disabled', false).removeClass('disabled');
		$(this).parent().parent().parent().find('button[checklist-number='+nextCheckboxPageID+']').prop('disabled', false).removeClass('disabled');
		$(this).parent().parent().parent().find('input[checklist-number='+nextCheckboxPageID+']').closest('.checklist-section').find('h4').removeClass('section-disabled');
		if($(this).parent().next('.checklist-checkbox-section').length == 0) {
			var nextProjectStage = $(this).parent().parent().parent().find('input[checklist-number='+nextCheckboxPageID+']').parent().parent().find('.checklist-header .checklist-stage').text();
			if(nextProjectStage == '') {
				projectDone = 'closed';
				$(document).find('.project-stage-due-date .project-stage').html(projectDone);
			}
			else $(document).find('.project-stage-due-date .project-stage').html(nextProjectStage);
			$(this).parent().parent().find('h4.checklist-header').addClass('section-complete').removeClass('ss-dropdown').addClass('ss-directright');
			$(this).parent().parent().find('.checklist-checkbox-section').hide();
		}
		else {
			nextProjectStage = '';
		}

		var skipProjectCheckboxesOptions = { 
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       changeProjectCheckboxesSuccess,  // post-submit callback
			dataType: 'json',
			data: { 
				_token: $(this).closest('form.change-project-checkboxes-form').find('input[name=_token]').attr('value'),
				id: $(this).closest('form.change-project-checkboxes-form').find('input[name=id]').attr('value'),
				value: checkboxID,
				checkboxValue: checkboxValue,
				user_finished_id: $(this).closest('form.change-project-checkboxes-form').find('input[name=user_finished_id]').attr('value'),
				thisPage: window.location.pathname,
				updatecheckbox: 'updatecheckbox',
				addskipnote: 'addskipnote',
				nextProjectStage: nextProjectStage,
			},
			type: 'POST',
			url: $(this).closest('form.change-project-checkboxes-form').attr('action'),
			resetForm: false        // reset the form after successful submit 
		};

		$(this).removeClass('changed-input');
		$(this).ajaxSubmit(skipProjectCheckboxesOptions);
		return false;
		
	});
	function changeProjectCheckboxesSuccess(data)
	{
		if(data.msg == 'pageneedsreloading') location.reload();
		if(data.msg == 'skippedtask') {
			$(document).find('button[checklist-number='+data.projecttaskid+']').remove();
		}
		// $('#message-box-json').fadeIn();
		// $('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-success">' + data.msg + '</span></div>');
	}
	
	// subscribe users to a project
	$(document).on('click', 'form.add-project .form-subscribe-buttons .subscribe', function(){
		var subscribe = $(this).attr('id');
		//console.log(ping);
		var currentSubscribed = $(this).closest('form.add-project').find('input.project-subscribed').attr('value');
		$(this).toggleClass('subscribe-selected');
		var allSelected = '';
		$(this).parent().find('.subscribe-selected').each(function(){
			var subSelected = $(this).attr('id');
			allSelected = subSelected+allSelected;
		});
		$(this).closest('form.add-project').find('input.project-subscribed').attr('value',allSelected);
	});
	// Edit Project
	// subscribe users to a project
	$(document).on('click', 'form.update-project .form-subscribe-buttons .subscribe', function(){
		var subscribe = $(this).attr('id');
		//console.log(ping);
		var currentSubscribed = $(this).closest('form.update-project').find('input.project-subscribed').attr('value');
		$(this).toggleClass('subscribe-selected');
		var allSelected = '';
		$(this).parent().find('.subscribe-selected').each(function(){
			var subSelected = $(this).attr('id');
			allSelected = subSelected+allSelected;
		});
		$(this).closest('form.update-project').find('input.project-subscribed').attr('value',allSelected);
	});
	// account active search of edit project page
	$(document).on('input','form.update-project .search-accounts', function() {
		var accountSearch = $(this).val();
		$(document).find('form.update-project .accounts-search-ajax').show().html('<span><img src="/images/ajax-snake-loader-grey.gif" alt="Searching..."> Searching...</span>');
		if(accountSearch.length >= 1) {
			// search accounts and return a list
			var accountEditSearchOptions = { 
				target:   '.accounts-search-ajax',   // target element(s) to be updated with server response 
				success:       accountEditSearchSuccess,  // post-submit callback
				dataType: 'json',
				data: { 
					_token: $(this).parent().parent().parent().find('input[name=_token]').attr('value'),
					title: accountSearch
				},
				type: 'POST',
				url: '/accounts/search/'+accountSearch,
				resetForm: false        // reset the form after successful submit 
			};
			$(this).find('.changed-input').each(function() {
				$(this).removeClass('changed-input');
			});
			$(this).ajaxSubmit(accountEditSearchOptions);
			return false;
		}
		// else {
		// 	$(document).find('form.update-project .accounts-search-ajax').show().html('<span>Please type at least 3 characters to start a search.</span>');
		// }
	});
	$(document).on('mouseenter','form.update-project .accounts-search-ajax span', function(){
		$(this).removeClass('search-hover');
	});
	$(document).on('click','form.update-project .accounts-search-ajax span', function() {
		var accountID = parseInt($(this).attr('value'),10);
		var accountText = $(this).text();
		$(this).closest('form.update-project').find('input[name=account_name]').val(accountText);
		$(this).closest('form.update-project').find('input[name=account_id]').attr('value',accountID);
		$(document).find('form.update-project .accounts-search-ajax').hide();
	});
	function accountEditSearchSuccess(data)
	{
		if(data.msg == 'found some') {
			$(document).find('form.update-project .accounts-search-ajax').show().html(data.accounts);
			$(document).find('form.update-project .accounts-search-ajax span').first().addClass('search-hover');
		}
		else {
			$(document).find('form.update-project .accounts-search-ajax').show().html('<p>No accounts found.</p>');
		}
	}
	// change project due date
	var calProjDueTemp = new Date();
	var calProjDueNow = new Date(calProjDueTemp.getFullYear(), calProjDueTemp.getMonth(), calProjDueTemp.getDate(), 0, 0, 0, 0);
	var calProjDuePost = $('#content form.update-project .project-due-date').datepicker({
		onRender: function(date) {
			return date.valueOf() < calProjDueNow.valueOf() ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
	   	calProjDuePost.hide();
	   	$('.dropdown-menu').hide();
	}).data('datepicker');
	// change project launch date
	var calProjLaunchTemp = new Date();
	var calProjLaunchNow = new Date(calProjLaunchTemp.getFullYear(), calProjLaunchTemp.getMonth(), calProjLaunchTemp.getDate(), 0, 0, 0, 0);
	var calProjLaunchPost = $('#content form.update-project .project-launch-date').datepicker({
		onRender: function(date) {
			return date.valueOf() < calProjLaunchNow.valueOf() ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
	   	calProjLaunchPost.hide();
	   	$('.dropdown-menu').hide();
	}).data('datepicker');
	// change project start date
	var calProjStartTemp = new Date();
	var calProjStartNow = new Date(calProjStartTemp.getFullYear(), calProjStartTemp.getMonth(), calProjStartTemp.getDate(), 0, 0, 0, 0);
	var calProjStartPost = $('#content form.update-project .project-start-date').datepicker({
		onRender: function(date) {
			return date.valueOf() < calProjStartNow.valueOf() ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
	   	calProjStartPost.hide();
	   	$('.dropdown-menu').hide();
	}).data('datepicker');
	// change project end date
	var calProjEndTemp = new Date();
	var calProjEndNow = new Date(calProjEndTemp.getFullYear(), calProjEndTemp.getMonth(), calProjEndTemp.getDate(), 0, 0, 0, 0);
	var calProjEndPost = $('#content form.update-project .project-end-date').datepicker({
		onRender: function(date) {
			return date.valueOf() < calProjEndNow.valueOf() ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
	   	calProjEndPost.hide();
	   	$('.dropdown-menu').hide();
	}).data('datepicker');
	$(document).on('submit','#projects-page form.delete-project', function() {
		var confirmCancel = confirm('Are you sure you want to delete this project?');
		
		if(confirmCancel == true) return true;
		else return false;
	});
	// add Delete option to attachments on project edit page
	$('#projects-page .post-edit-attachment').hover(function(){
		$(this).append('<span class="ss-delete delete-attachment"></span>');
	}, function(){
		$(this).find('.delete-attachment').remove();
	});
	// delete attachment with ajax on project edit page
	$(document).on('click', '#projects-page .post-edit-attachment', function() {
		var confirmCancel = confirm('Are you sure you want to delete this attachment?');
		
		if(confirmCancel == true) {
			var imageName = $(this).find('a img').attr('alt');
			var imagePath = $(this).find('a').attr('href');
			var imageId = $(this).parent().parent().find('form.update-project').attr('id');
			var imageToken = $(this).parent().parent().find('form.update-project input[name=_token]').val();
			$.post(
				'/projects/post/'+imageId+'/remove/'+imageName,
				{
					"_token": imageToken,
					"imageName" : imageName,
					"imagePath" : imagePath,
					"id" : imageId,
				}, function (data) {
					if(data.errorMsg) {
						$('#message-box-json').fadeIn();
						$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
					}
					else {
						$('#message-box-json').find('.section').empty();
						$('#message-box-json').fadeOut();
						window.location.href = data.path;
					}
				},'json'
			);
		}
	});
	// project comments
	// load comment form on project single view page.
	$(document).on('click', '#projects-page #projects-post-comment-form .post-comment', function(){
		$('.post-comment').each(function(){
			$(this).prop('disabled',true);
		});
		$('#comments').after('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
		
		var projectSlug = $(document).find('.projects-post').attr('slug');
		//console.log(projectSlug);
		$.get( "/projects/post/"+projectSlug+"/comment", function( data ) {

			$('#comments').append(data);
			$(document).find('.loading-something-new').remove();
			$('#comments .projects-post-new-comment.create-something-form').slideDown(400);
			$('#comments .projects-post-new-comment.create-something-form').addClass('reply-to-project-form');			
			$('.projects-post-new-comment.create-something-form input[name=project-slug]').val(projectSlug);
			$('.post-comment').each(function(){
				$(this).prop('disabled',true);
			});
			$('#content #projects-post-comment-form.create-something-new .add-button').addClass('active');
			$('#content form.add-comment .comment-content').focus();

		});
	});
	// cancel project post reply
	$(document).on('click','#projects-page .projects-post-new-comment.create-something-form span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Save as draft to keep changes or continue to discard changes. Continue?');
		
			if(confirmCancel == true) {
				$(document).find('.projects-post-new-comment.create-something-form').slideUp(400,function(){
					$(document).find('.projects-post-new-comment.create-something-form').remove();
					$('#content #projects-post-comment-form.create-something-new .add-button').removeClass('active');
					$('.post-comment').each(function(){
						$(this).prop('disabled', false);
					});
				});
				$('#message-box-json').find('.section').empty();
				$('#message-box-json').fadeOut();
			}
		}
		else {
				$(document).find('.projects-post-new-comment.create-something-form').slideUp(400,function(){
					$(document).find('.projects-post-new-comment.create-something-form').remove();
					$('#content #projects-post-comment-form.create-something-new .add-button').removeClass('active');
					$('#content #comment-post-comment-form.create-something-new .add-button').removeClass('active');
					$('.post-comment').each(function(){
						$(this).prop('disabled', false);
					});
				});
			$('#message-box-json').find('.section').empty();
			$('#message-box-json').fadeOut();
		}
	});
	// submit reply to project
	var projectCommentOptions = { 
		target:   '#message-box-json .section',   // target element(s) to be updated with server response 
		success:       projectCommentSuccess,  // post-submit callback 
		resetForm: false        // reset the form after successful submit 
	};	        
	$(document).on('submit','#projects-page .projects-post-new-comment.reply-to-project-form form.add-comment', function() {
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
	    $(this).ajaxSubmit(projectCommentOptions);
	    return false;
	});
	function projectCommentSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-success">'+data.msg+'</span></div>');
		    //console.log(data.comment_id);
			window.location.href = '/projects/post/'+data.slug+'?comment=new#comment-'+data.comment_id;
			if(window.location.search == '?comment=new') window.location.reload(true);
		}
	}
	//load comment form on reply of comment button click
	$(document).on('click', '#projects-page #comment-post-comment-form .post-comment', function(){
		$('.post-comment').each(function(){
			$(this).prop('disabled',true);
		});
		
		var projectSlug = $(document).find('.projects-post').attr('slug');
		//console.log(projectSlug);
		var commentId = $(this).closest('.office-post-comment').attr('id');
		var commentHeight = $(this).closest('.office-post-comment').height();
		commentHeight = commentHeight-15;
		var commentAuthor = $(document).find('#'+commentId+' .comment-author').attr('author');
		$('#'+commentId).after('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
		//commentId = commentId.replace('comment-','');
		//console.log(commentId);
		$.get( "/projects/post/"+projectSlug+"/comment", function( data ) {
			$('#'+commentId).after(data);
			$(document).find('.loading-something-new').remove();
			$('#content .projects-post-new-comment.create-something-form').slideDown(400);
			$('#content .projects-post-new-comment.create-something-form').addClass('reply-to-comment-form');
			$('.projects-post-new-comment.create-something-form input[name=project-slug]').val(projectSlug);
			$('.post-comment').each(function(){
				$(this).prop('disabled',true);
			});
			$('#'+commentId).find('#comment-post-comment-form.create-something-new .add-button').addClass('active');
			$('#content .projects-post-new-comment.create-something-form h3').html('Reply to '+commentAuthor+'\'s comment:');
			$('#content form.add-comment .comment-content').focus();
		});
	});
	// submit comment on a comment
	$(document).on('submit','#projects-page .projects-post-new-comment.reply-to-comment-form form.add-comment', function() {
		var commentReplyToId = $(document).find('#projects-page .projects-post-new-comment.reply-to-comment-form').prev().attr('id');
		if(commentReplyToId) commentReplyToId = commentReplyToId.replace('comment-','');
		else commentReplyToId = 0;
		// submit reply to comment
		var projectCommentCommentOptions = {
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       projectCommentCommentSuccess,  // post-submit callback 
			resetForm: false,        // reset the form after successful submit 
			data: { reply_to_id: commentReplyToId }
		};
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
		$(this).ajaxSubmit(projectCommentCommentOptions);
	    return false; 
	});
	function projectCommentCommentSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-success">'+data.msg+'</span></div>');
		   	//console.log(data.slug);
			window.location.href = '/projects/post/'+data.slug+'?comment=new#comment-'+data.comment_id;
			if(window.location.search == '?comment=new') window.location.reload(true);
		}
	}
	// edit comment
	$(document).on('click', '#projects-page .comment-edit-button a.edit-comment', function(){
		
		var projectSlug = $(document).find('.projects-post').attr('slug');
		
		var commentIdBox = $(this).closest('.office-post-comment').attr('id');
		var commentId = commentIdBox.replace('comment-','');
		//console.log(commentId);
		$.get( "/projects/post/comment/"+commentId+"/edit", function( data ) {
			$(document).find('#projects-page .comment-edit-button a.edit-comment').each(function(){
				$(this).hide();
			});
			$(document).find('#comment-post-comment-form .post-comment').each(function(){
				$(this).hide();
			});
			$('#'+commentIdBox+' .comment-contents').html(data);
			$('#'+commentIdBox+' .edit-something-form').fadeIn();
			$('#'+commentIdBox+' .comment-contents').find('input[name=project-slug]').val(projectSlug);
			$('form.edit-comment .update-comment-content').focus();
		});
	});
	// cancel editing a comment
	$(document).on('click','#projects-page form.edit-comment span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Save as draft to keep changes or continue to discard changes. Continue?');
		
			if(confirmCancel == true) {
				$(document).find('.changed-input').each(function() {
					$(this).removeClass('changed-input');
				});
				var pageHref = window.location.href;
				window.location.reload(true);
			}
		}
		else {
			var pageHref = window.location.href;
			window.location.reload(true);
		}
	});
	// submit edit on comment
	$(document).on('submit','#projects-page form.edit-comment #update-comment', function() {
		var editProjectCommentOptions = { 
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       commentProjectEditSuccess,  // post-submit callback 
			resetForm: false        // reset the form after successful submit 
		};	 
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
	    $(this).ajaxSubmit(editProjectCommentOptions);
	    return false;
	});
	function commentProjectEditSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-success">'+data.msg+'</span></div>');
		   	//console.log(data.comment_id);
			//window.location.href = '/news/article/'+data.slug+'?comment=edit#comment-'+data.comment_id;
			//if(window.location.search == '?comment=edit') window.location.reload(true);
		}
	}
	// add option to delete attachment
	$(document).on('mouseenter', '#projects-page .comment-edit-attachment', function(){
		$(this).append('<span class="ss-delete delete-attachment"></span>');
	});
	$(document).on('mouseleave', '#projects-page .comment-edit-attachment', function(){
		$(this).find('.delete-attachment').remove();
	});
	// delete comment attachment with ajax
	$(document).on('click', '#projects-page .comment-edit-attachment', function() {
		var confirmCancel = confirm('Are you sure you want to delete this attachment?');
		
		if(confirmCancel == true) {
			var imageName = $(this).find('a img').attr('alt');
			var imagePath = $(this).find('a').attr('href');
			var imageId = $(this).closest('.office-post-comment').attr('id');
			imageId = imageId.replace('comment-','');
			var imageToken = $(this).closest('form.edit-comment').find('input[name=_token]').val();
			$.post(
				'/projects/post/comment/'+imageId+'/remove/'+imageName,
				{
					"_token": imageToken,
					"imageName" : imageName,
					"imagePath" : imagePath,
					"id" : imageId,
				}, function (data) {
					if(data.errorMsg) {
						$('#message-box-json').fadeIn();
						$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
					}
					else {
						$('#message-box-json').find('.section').empty();
						$('#message-box-json').fadeOut();
						//console.log(data.image);
						$(document).find('a[href="'+ data.image +'"]').fadeOut();
						//window.location.href = data.path;
					}
				},'json'
			);
		}
	});

	/* Accounts */
	// add new account
	$(document).on('click','#page-nav_menu #accounts-new-account-form .add-button',function(){
		$('.add-button').each(function(){
			$(this).prop('disabled',true);
		});
		$('.inner-page').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."> Loading Form...</span>');
		$.get( "/accounts", function( data ) {
			$('.inner-page').before(data);
			$(document).find('.loading-something-new').remove();
			$('#content .account-add-form.create-something-form').slideDown(400);
			$('#page-nav_menu #accounts-new-account-form.create-something-new .add-button').addClass('active');
			$('.add-button').each(function(){
				$(this).prop('disabled',true);
			});
		});
	});
	// cancel adding new account
	$(document).on('click','#content .account-add-form span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Continue to discard changes. Continue?');
		
			if(confirmCancel == true) {
				$(document).find('.account-add-form.create-something-form').slideUp(400,function(){
					$(document).find('.account-add-form.create-something-form').remove();
					$('#page-nav_menu #accounts-new-account-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
				});
				$('#message-box-json').find('.section').empty();
				$('#message-box-json').fadeOut();
			}
		}
		else {
			$(document).find('.account-add-form.create-something-form').slideUp(400,function(){
				$(document).find('.account-add-form.create-something-form').remove();
					$('#page-nav_menu #accounts-new-account-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
			});
			$('#message-box-json').find('.section').empty();
			$('#message-box-json').fadeOut();
		}
	});
	
	/* Billables */
	// add new billable
	$(document).on('click','#page-nav_menu #billables-new-billable-form .add-button',function(){
		$('.add-button').each(function(){
			$(this).prop('disabled',true);
		});
		$('.inner-page').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."> Loading Form...</span>');
		$.get( "/billables", function( data ) {
			$('.inner-page').before(data);
			$(document).find('.loading-something-new').remove();
			$('#content .billable-add-form.create-something-form').slideDown(400);
			$('#page-nav_menu #billables-new-billable-form.create-something-new .add-button').addClass('active');
			$('.add-button').each(function(){
				$(this).prop('disabled',true);
			});
		});
	});
	// cancel adding new billable
	$(document).on('click','#content .billable-add-form span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Continue to discard changes. Continue?');
		
			if(confirmCancel == true) {
				$(document).find('.billable-add-form.create-something-form').slideUp(400,function(){
					$(document).find('.billable-add-form.create-something-form').remove();
					$('#page-nav_menu #billables-new-billable-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
				});
				$('#message-box-json').find('.section').empty();
				$('#message-box-json').fadeOut();
			}
		}
		else {
			$(document).find('.billable-add-form.create-something-form').slideUp(400,function(){
				$(document).find('.billable-add-form.create-something-form').remove();
					$('#page-nav_menu #billables-new-billable-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
			});
			$('#message-box-json').find('.section').empty();
			$('#message-box-json').fadeOut();
		}
	});

	/* Invoices */
	// add new invoice
	$(document).on('click','#page-nav_menu #invoices-new-invoice-form .add-button',function(){
		$('.add-button').each(function(){
			$(this).prop('disabled',true);
		});
		$('.inner-page').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."> Loading Form...</span>');
		$.get( "/invoices", function( data ) {
			$('.inner-page').before(data);
			$(document).find('.loading-something-new').remove();
			$('#content .invoice-add-form.create-something-form').slideDown(400);
			$('#page-nav_menu #invoices-new-invoice-form.create-something-new .add-button').addClass('active');
			$('.add-button').each(function(){
				$(this).prop('disabled',true);
			});
		});
	});
	// cancel adding new invoice
	$(document).on('click','#content .invoice-add-form span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Continue to discard changes. Continue?');
		
			if(confirmCancel == true) {
				$(document).find('.invoice-add-form.create-something-form').slideUp(400,function(){
					$(document).find('.invoice-add-form.create-something-form').remove();
					$('#page-nav_menu #invoices-new-invoice-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
				});
				$('#message-box-json').find('.section').empty();
				$('#message-box-json').fadeOut();
			}
		}
		else {
			$(document).find('.invoice-add-form.create-something-form').slideUp(400,function(){
				$(document).find('.invoice-add-form.create-something-form').remove();
					$('#page-nav_menu #invoices-new-invoice-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
			});
			$('#message-box-json').find('.section').empty();
			$('#message-box-json').fadeOut();
		}
	});

	/* Help */
	// add new help
	$(document).on('click','#page-nav_menu #help-new-help-form .add-button',function(){
		$('.add-button').each(function(){
			$(this).prop('disabled',true);
		});
		$('.inner-page').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."> Loading Form...</span>');
		$.get( "/help", function( data ) {
			$('.inner-page').before(data);
			$(document).find('.loading-something-new').remove();
			$('#content .help-add-form.create-something-form').slideDown(400);
			$('#page-nav_menu #help-new-help-form.create-something-new .add-button').addClass('active');
			$('.add-button').each(function(){
				$(this).prop('disabled',true);
			});
		});
	});
	// cancel adding new help
	$(document).on('click','#content .help-add-form span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Continue to discard changes. Continue?');
		
			if(confirmCancel == true) {
				$(document).find('.help-add-form.create-something-form').slideUp(400,function(){
					$(document).find('.help-add-form.create-something-form').remove();
					$('#page-nav_menu #help-new-help-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
				});
				$('#message-box-json').find('.section').empty();
				$('#message-box-json').fadeOut();
			}
		}
		else {
			$(document).find('.help-add-form.create-something-form').slideUp(400,function(){
				$(document).find('.help-add-form.create-something-form').remove();
					$('#page-nav_menu #help-new-help-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
			});
			$('#message-box-json').find('.section').empty();
			$('#message-box-json').fadeOut();
		}
	});
	
	/* Wiki */
	// add new wiki
	$(document).on('click','#page-nav_menu #wiki-new-wiki-form .add-button',function(){
		$('.add-button').each(function(){
			$(this).prop('disabled',true);
		});
		$('.inner-page').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."> Loading Form...</span>');
		$.get( "/wiki", function( data ) {
			$('.inner-page').before(data);
			$(document).find('.loading-something-new').remove();
			$('#content .wiki-add-form.create-something-form').slideDown(400);
			$('#page-nav_menu #wiki-new-wiki-form.create-something-new .add-button').addClass('active');
			$('.add-button').each(function(){
				$(this).prop('disabled',true);
			});
		});
	});
	// cancel adding new wiki
	$(document).on('click','#content .wiki-add-form span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Continue to discard changes. Continue?');
		
			if(confirmCancel == true) {
				$(document).find('.wiki-add-form.create-something-form').slideUp(400,function(){
					$(document).find('.wiki-add-form.create-something-form').remove();
					$('#page-nav_menu #wiki-new-wiki-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
				});
				$('#message-box-json').find('.section').empty();
				$('#message-box-json').fadeOut();
			}
		}
		else {
			$(document).find('.wiki-add-form.create-something-form').slideUp(400,function(){
				$(document).find('.wiki-add-form.create-something-form').remove();
					$('#page-nav_menu #wiki-new-wiki-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
			});
			$('#message-box-json').find('.section').empty();
			$('#message-box-json').fadeOut();
		}
	});

	/* To-Do List page */
	$(document).on('change','#page-nav_menu .filter-user.todo-filter', function(){
		//$('#content').find('.loading-something-new').show().delay(500);

		var authorLink = $(this).val();
		window.location.href='/to-do/'+authorLink;
	});

	/* Vault */
	$(document).on('change','#page-nav_menu .filter-vault-tag.tags-filter', function(){
		var tagLink = $(this).val();
		window.location.href='/assets/vault/tags/'+tagLink;
	});
	$(document).on('click','#content .vault-asset.office-post-single .show-me', function() {
		var vaultAssetLink = $(this).closest('.office-post-single').attr('slug');
		$.get( "/assets/vault/asset/"+vaultAssetLink, function( data ) {
			if(data.errorMsg) {
				//console.log('please redirect');
				window.location.href='/assets/vault';
			}
			$(document).find('#content .vault-asset.office-post-single .vault-password').val(data.asset);
			$(document).find('#content .vault-asset.office-post-single .show-me').hide();
		});
	});
	// add new vault asset
	$(document).on('click','#page-nav_menu #vault-new-vault-form .add-button',function(){
		$('.add-button').each(function(){
			$(this).prop('disabled',true);
		});
		$('.inner-page').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."> Loading Form...</span>');
		$.get( "/assets/vault", function( data ) {
			if(data.errorMsg) {
				//console.log('please redirect');
				window.location.href='/assets/vault';
			}
			$('.inner-page').before(data);
			$(document).find('.loading-something-new').remove();
			$('#content .vault-add-form.create-something-form').slideDown(400);
			$('#page-nav_menu #vault-new-vault-form.create-something-new .add-button').addClass('active');
			$('#content .vault-add-form.create-something-form .vault-hidden').closest('.new-form-field').hide();
			$('.add-button').each(function(){
				$(this).prop('disabled',true);
			});

			// active search of accounts
			$(document).on('input','form.add-vault-asset .search-accounts', function() {
				var accountSearch = $(this).val();
				$(document).find('form.add-vault-asset .accounts-search-ajax').show().html('<span><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."> Searching...</span>');
				if(accountSearch.length >= 1) {
					// search accounts and return a list
					var accountVaultSearchOptions = { 
						target:   '.accounts-search-ajax',   // target element(s) to be updated with server response 
						success:       accountVaultSearchSuccess,  // post-submit callback
						dataType: 'json',
						data: { 
							_token: $(this).parent().parent().parent().find('input[name=_token]').attr('value'),
							title: accountSearch
						},
						type: 'POST',
						url: '/accounts/search/'+accountSearch,
						resetForm: false        // reset the form after successful submit 
					};
					$(this).find('.changed-input').each(function() {
						$(this).removeClass('changed-input');
					});
					$(this).ajaxSubmit(accountVaultSearchOptions);
					return false;
				}
			});
			$(document).on('mouseenter','form.add-vault-asset .accounts-search-ajax span', function(){
				$(this).removeClass('search-hover');
			});
			$(document).on('click','form.add-vault-asset .accounts-search-ajax span', function() {
				var accountID = parseInt($(this).attr('value'),10);
				var accountText = $(this).text();
				$(this).closest('form.add-vault-asset').find('input[name=account_name]').val(accountText);
				$(this).closest('form.add-vault-asset').find('input[name=account_id]').attr('value',accountID);
				$(document).find('form.add-vault-asset .accounts-search-ajax').hide();
			});

			// active search of tags
			$(document).on('input','form.add-vault-asset .search-tags', function() {
				var tagsSearch = $(this).val();
				$(document).find('form.add-vault-asset .tags-search-ajax').show().html('<span><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."> Searching...</span>');
				if(tagsSearch.length >= 1) {
					// search tags and return a list
					var tagsVaultSearchOptions = { 
						target:   '.tags-search-ajax',   // target element(s) to be updated with server response 
						success:       tagsVaultSearchSuccess,  // post-submit callback
						dataType: 'json',
						data: { 
							_token: $(this).parent().parent().parent().find('input[name=_token]').attr('value'),
							title: tagsSearch
						},
						type: 'POST',
						url: '/tags/search/'+tagsSearch,
						resetForm: false        // reset the form after successful submit 
					};
					$(this).find('.changed-input').each(function() {
						$(this).removeClass('changed-input');
					});
					$(this).ajaxSubmit(tagsVaultSearchOptions);
					return false;
				}
			});
			$(document).on('mouseenter','form.add-vault-asset .tags-search-ajax span', function(){
				$(this).removeClass('search-hover');
			});
			$(document).on('click','form.add-vault-asset .tags-search-ajax span.tags-searched', function() {
				var existingTagsID = $(this).closest('form.add-vault-asset').find('input[name=tag_id]').attr('value');
				//console.log(existingTagsID);
				var tagsID = parseInt($(this).attr('value'),10);
				var tagsText = $(this).text();
				$(this).closest('form.add-vault-asset').find('.tags-added-ajax').append('<span class="tag-added tag-name"><a class="ss-tag">'+tagsText+'</a></span>');
				if(existingTagsID == null) $(this).closest('form.add-vault-asset').find('input[name=tag_id]').attr('value',tagsID);
				else $(this).closest('form.add-vault-asset').find('input[name=tag_id]').attr('value',existingTagsID+','+tagsID);
				$(document).find('form.add-vault-asset .tags-search-ajax').hide();
				$(this).closest('form.add-vault-asset').find('input[name=tag_name]').val('');
				$(this).closest('form.add-vault-asset').find('.changed-input').each(function() {
					$(this).removeClass('changed-input');
				});
			});
			$(document).on('click','form.add-vault-asset .tags-search-ajax span.tag-addnew', function() {
				var tagsNewText = $(this).text();
				var tagsAddNewOptions = { 
					target:   '.tags-added-ajax',   // target element(s) to be updated with server response 
					success:       tagsAddNewSuccess,  // post-submit callback
					dataType: 'json',
					data: { 
						_token: $(this).parent().parent().parent().parent().find('input[name=_token]').attr('value')
					},
					type: 'POST',
					url: '/tags/newtag/'+tagsNewText,
					resetForm: false        // reset the form after successful submit 
				};
				$(this).find('.changed-input').each(function() {
					$(this).removeClass('changed-input');
				});
				$(this).ajaxSubmit(tagsAddNewOptions);
				return false;
			});
			$(document).on('click','form.add-vault-asset .tags-search-ajax p', function() {
				$(document).find('form.add-vault-asset .tags-search-ajax').hide();
			});
		});
	});
	function tagsAddNewSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-success">'+data.msg+'</span></div>');
			var existingTagsID = $(document).find('form.add-vault-asset input[name=tag_id]').attr('value');
			//console.log(existingTagsID);
			var tagNewID = data.tagID;
			var tagNewText = data.tagname;
			$(document).find('form.add-vault-asset .tags-added-ajax').append('<span class="tag-added tag-name"><a class="ss-tag">'+tagNewText+'</a></span>');
			if(existingTagsID == null) $(document).find('form.add-vault-asset input[name=tag_id]').attr('value',tagNewID);
			else $(document).find('form.add-vault-asset input[name=tag_id]').attr('value',existingTagsID+','+tagNewID);
			$(document).find('form.add-vault-asset .tags-search-ajax').hide();
			$(document).find('form.add-vault-asset input[name=tag_name]').val('');
			$(document).find('form.add-vault-asset .changed-input').each(function() {
					$(this).removeClass('changed-input');
				});
			$('#message-box-json').delay(4000).fadeOut();
		}
	}
	function tagsVaultSearchSuccess(data)
	{
		if(data.msg == 'found some') {
			$(document).find('form.add-vault-asset .tags-search-ajax').show().html(data.tagsSearch);
			$(document).find('form.add-vault-asset .tags-search-ajax span').first().addClass('search-hover');
		}
		else {
			$(document).find('form.add-vault-asset .tags-search-ajax').show().html('<p>No existing tags found matching the search criteria. [x]</p><p>Create Tag: </p><span value="'+data.tagsSearch+'" class="tag-addnew tag-name"><a class="ss-tag">'+data.tagsSearch+'</a></span>');
		}
	}
	function accountVaultSearchSuccess(data)
	{
		if(data.msg == 'found some') {
			$(document).find('form.add-vault-asset .accounts-search-ajax').show().html(data.accounts);
			$(document).find('form.add-vault-asset .accounts-search-ajax span').first().addClass('search-hover');
		}
		else {
			$(document).find('form.add-vault-asset .accounts-search-ajax').show().html('<p>No accounts found. [x]</p>');
		}
	}
	// cancel adding new vault asset
	$(document).on('click','#content .vault-add-form span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Continue to discard changes. Continue?');
		
			if(confirmCancel == true) {
				$(document).find('.vault-add-form.create-something-form').slideUp(400,function(){
					$(document).find('.vault-add-form.create-something-form').remove();
					$('#page-nav_menu #vault-new-vault-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
				});
				$('#message-box-json').find('.section').empty();
				$('#message-box-json').fadeOut();
			}
		}
		else {
			$(document).find('.vault-add-form.create-something-form').slideUp(400,function(){
				$(document).find('.vault-add-form.create-something-form').remove();
					$('#page-nav_menu #vault-new-vault-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
			});
			$('#message-box-json').find('.section').empty();
			$('#message-box-json').fadeOut();
		}
	});
	
	$(document).on('change','#content .add-vault-asset select', function() {
		var vaultType = $(this).val();
		//console.log(vaultType);
		if(vaultType == 'website') {
			$('#content .vault-add-form.create-something-form .vault-field').closest('.new-form-field').slideUp(400);
			$('#content .vault-add-form.create-something-form .vault-url').closest('.new-form-field').find('label').html('URL:');
			$('#content .vault-add-form.create-something-form .vault-url').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-username').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-password').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-notes').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-attachments').closest('.new-form-field').slideDown(400);
		}
		if(vaultType == 'ftp') {
			$('#content .vault-add-form.create-something-form .vault-field').closest('.new-form-field').slideUp(400);
			$('#content .vault-add-form.create-something-form .vault-url').closest('.new-form-field').find('label').html('Server:');
			$('#content .vault-add-form.create-something-form .vault-url').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-username').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-password').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-ftp-path').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-notes').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-attachments').closest('.new-form-field').slideDown(400);
		}
		if(vaultType == 'database') {
			$('#content .vault-add-form.create-something-form .vault-field').closest('.new-form-field').slideUp(400);
			$('#content .vault-add-form.create-something-form .vault-url').closest('.new-form-field').find('label').html('Server:');
			$('#content .vault-add-form.create-something-form .vault-url').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-username').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-password').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-database-name').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-notes').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-attachments').closest('.new-form-field').slideDown(400);
		}
		if(vaultType == 'email') {
			$('#content .vault-add-form.create-something-form .vault-field').closest('.new-form-field').slideUp(400);
			$('#content .vault-add-form.create-something-form .vault-url').closest('.new-form-field').find('label').html('URL:');
			$('#content .vault-add-form.create-something-form .vault-url').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-username').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-password').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-notes').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-attachments').closest('.new-form-field').slideDown(400);
		}
		if(vaultType == 'server') {
			$('#content .vault-add-form.create-something-form .vault-field').closest('.new-form-field').slideUp(400);
			$('#content .vault-add-form.create-something-form .vault-url').closest('.new-form-field').find('label').html('Server:');
			$('#content .vault-add-form.create-something-form .vault-url').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-username').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-password').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-notes').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-attachments').closest('.new-form-field').slideDown(400);
		}
		if(vaultType == 'generic') {
			$('#content .vault-add-form.create-something-form .vault-field').closest('.new-form-field').slideUp(400);
			$('#content .vault-add-form.create-something-form .vault-url').closest('.new-form-field').find('label').html('URL:');
			$('#content .vault-add-form.create-something-form .vault-url').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-username').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-password').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-notes').closest('.new-form-field').slideDown(400);
			$('#content .vault-add-form.create-something-form .vault-attachments').closest('.new-form-field').slideDown(400);
		}
	});
	// submit new vault asset
	var addVaultAssetOptions = { 
		target:   '#message-box-json .section',   // target element(s) to be updated with server response 
		success:       afterAddVaultAssetSuccess,  // post-submit callback 
		resetForm: false        // reset the form after successful submit 
	};	        
	$(document).on('submit','#content .vault-add-form form.add-vault-asset', function() {
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
	    $(this).ajaxSubmit(addVaultAssetOptions);
	    //console.log('submit');
	    return false; 
	});
	function afterAddVaultAssetSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-success">'+data.msg+'</span></div>');
		    //console.log('success');
			window.location.href = '/assets/vault/asset/'+data.slug;
		}
	}
	
	
	// $('#link-search').click( function() {
	// 	$('#search-box').fadeIn();
	// 	$('#search-box input.search').focus();
	// });
	// $(document).on('click','#search-box .ss-delete',function(){
	// 	$('#search-box input.search').blur();
	// 	$('#search-box').fadeOut();
	// });
	// $('#search-box input').keyup( function(ev) {
	// 	// hide if press esc
	// 	if ( ev.keyCode == 27 ) {
	// 		$(this).blur();
	// 		$('#search-box').fadeOut();
	// 	}
	// });
	// $('body').keydown( function( event ) {
	// 	if ( event.which == 191 ) { // '/' really. slash.
	// 		if ( $('input, textarea').is(":focus") ) {} else {
	// 		event.preventDefault();
	// 			$('#search-box').fadeIn();
	// 			$('#search-box input.search').focus();
	// 		}
	// 	}
	// });

	$(document).on('change keyup keydown', 'input, textarea, select', function(e){
		if($(this).parent().attr('class') == 'add-vacation-profile') return;
		if($(this).attr('class') == 'filter-author') return;
		if($(this).attr('class') == 'filter-date') return;
		if($(this).attr('class') == 'filter-type') return;
		if($(this).attr('class') == 'filter-status') return;
		if($(this).attr('class') == 'filter-priority') return;
		if($(this).attr('class') == 'filter-user') return;
		if($(this).attr('class') == 'filter-stage') return;
		if($(this).hasClass('show-hide-calendar')) return;
		if($(this).hasClass('news-filter') ) return;
		if($(this).hasClass('tags-filter') ) return;
		if($(this).hasClass('projects-filter') ) return;
		if($(this).hasClass('todo-filter') ) return;
		if($(this).hasClass('checklist-checkbox') ) return;
		if($(this).hasClass('show-me-input') ) return;
		if($(this).attr('class') == 'calendar-jump-to-date') return;
		if($(this).parent().parent().attr('class') == 'login-form') return;
		if($(this).parent().parent().attr('class') == 'login-remind') return;
		if($(this).parent().parent().attr('class') == 'login-reset') return;
		if($(this).parent().attr('class') == 'office-search') return;
		if($(this).closest('.template-output').attr('class') == 'template-output') return;
		if($(this).attr('class') == 'change-project-user-list') return;
		if($(this).attr('class') == 'change-project-manager-list') return;
		if($(this).attr('name') == 'change-project-priority') return;
		if($(this).attr('class') == 'change-project-stage-list') return;
		if($(this).attr('class') == 'add-project-sub-list') return;
		$(this).addClass('changed-input');
	});
	$(document).on('submit', 'form', function() {
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
	})
	$(window).on('beforeunload', function() {
		if($('.changed-input').length) {			
			return 'There are unsaved changes. Continue?';
		}
	});
});
</script>