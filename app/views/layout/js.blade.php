<script type="text/javascript" src="/js/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="/js/jquery.colorbox-min-1.5.9.js"></script>
<script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/js/jquery.form-3.51.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
	$("a[href $= 'gif'],a[href $= 'jpg'],a[href $= 'jpeg'],a[href $= 'JPG'],a[href $= 'JPEG'],a[href $= 'PNG'],a[href $= 'png']").colorbox({ opacity: '0.6',maxHeight:'80%', maxWidth: '80%' });
	
	$('.loading-something-new').hide();

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
		// $(commentUrlHash).find('.comment-details').css({
		// 	'background': 'rgba(201,99,0,0.5)',
		// 	'border-top': '1px solid #c60',
		// 	'border-right': '1px solid #c60',
		// 	'border-left': '1px solid #c60'
		// });
		// $(commentUrlHash).find('.comment-contents p').css({
		// 	'border-bottom': '1px solid #c60',
		// 	'border-right': '1px solid #c60',
		// 	'border-left': '1px solid #c60'
		// });
	}
	//Update active status of a menu link (both top menu bar and user menu bar)
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
	// var zIndex = 80;
	// $('#menu_links .link').each(function(){
	// 	$(this).css('z-index',zIndex);
	// 	zIndex = zIndex-1;
	// });
	// show arrow for sub menu on specific main menu item
	// if($(document).find('#menu_header ul#menu_links li.active').length) {
	// 	var activeMenuItem = $(document).find('#menu_header ul#menu_links li.active').offset().left;
	// 	var contentEdge = $(document).find('#content').offset().left;
	// 	var activeMenuPos = activeMenuItem-contentEdge+40;
	// 	$(document).find('#content .page-menu-arrow').css({
	// 		'margin-left': activeMenuPos+'px'
	// 	});
	// }
	
	// show sub menu on hover
	$('#menu_header ul#menu_links li.link').hover(function(){
		$(this).children('ul.sub_menu_links-hover').css({
			'visibility': 'visible'
		}).fadeIn(400).show();
		$(this).addClass('hover');
	},function(){
		$(this).children('ul.sub_menu_links-hover').css({
			'visibility': 'hidden'
		}).hide();
		$(this).removeClass('hover');
	});
	$('#user-box div.profile-dropdown').hover(function(){
		$(this).children('ul.sub_menu_links-hover').css({
			'visibility': 'visible'
		}).fadeIn(400).show();
		$(this).addClass('hover');
	},function(){
		$(this).children('ul.sub_menu_links-hover').css({
			'visibility': 'hidden'
		}).hide();
		$(this).removeClass('hover');
	});

	//menu dropdowns
	// $(".the_menu ul li.arrow").hover(function() { //When hovering...
	// 	$(this).children("ul.subnav").slideDown(0400).show(); //Slide down
	// 	$(this).children("ul.subnav").css('visibility', 'visible'); //bring back visibility while sliding down
	// },
	// function() {
	// 	$(this).children("ul.subnav").css('visibility', 'hidden'); //instantly hide on mouseout
	// 	$(this).children("ul.subnav").hide(); //Slide back up
	// });
	// $(".the_menu ul li").hover(function() { //When hovering...
	// 	$(this).addClass("hovering"); 
	// },
	// function() {
	// 	$(this).removeClass("hovering"); 
	// });
	
	//for search icon popup
	$(document).on('click', '#menu_header .menu_nav ul#menu_links li.link#link-search .ss-search', function() {
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

	// Detect window height and change menu to position:absolute, etal
	// var menuHeight = $(document).find('#nav_menu #menu_header .menu_nav #menu_links').height();
	// menuHeight = menuHeight+45+92;
	// var windowHeight = $(window).height();
	// var documentHeight = $('html').height();
	// if(menuHeight >= windowHeight) {

	// 	if(documentHeight < windowHeight) {
	// 		$(document).find('#nav_menu').css({
	// 			'position':'absolute',
	// 			'top':'44px',
	// 			'height':menuHeight+'px'
	// 		});
	// 	}
	// 	else {
	// 		$(document).find('#nav_menu').css({
	// 			'position':'absolute',
	// 			'top':'44px',
	// 			'height':documentHeight+'px'
	// 		});
	// 	}
	// 	// $(document).find('#nav_menu #menu_header .menu_nav #menu_links li#link-dashboard').css({
	// 	// 	'position':'fixed',
	// 	// 	'top':'0',
	// 	// 	'left':'0',
	// 	// 	'width':'12%',
	// 	// 	'z-index': '60',
	// 	// 	'padding-left':'0px',
	// 	// 	'background': 'linear-gradient(to bottom,  #4b83b4 0%,#3c698c 100%)'
	// 	// });
	// 	// $(document).find('#nav_menu #menu_header .menu_nav #menu_links li#link-dashboard img').css({
	// 	// 	'margin-left': '5px'
	// 	// });
	// }

	// $(window).on('resize',function() {
	// 	var menuHeight = $(document).find('#nav_menu #menu_header .menu_nav #menu_links').height();
	// 	var windowHeight = $(window).height();
	// 	var documentHeight = $('html').height();

	// 	if(menuHeight >= windowHeight) {
	// 		if(documentHeight < windowHeight) {
	// 			$(document).find('#nav_menu').css({
	// 				'position':'absolute',
	// 				'top':'44px',
	// 				'height':menuHeight+'px'
	// 			});
	// 		}
	// 		else {
	// 			$(document).find('#nav_menu').css({
	// 				'position':'absolute',
	// 				'top':'44px',
	// 				'height':documentHeight+'px'
	// 			});
	// 		}
	// 		// $(document).find('#nav_menu #menu_header .menu_nav #menu_links li#link-dashboard').css({
	// 		// 	'position':'fixed',
	// 		// 	'top':'0',
	// 		// 	'left':'0',
	// 		// 	'width':'12%',
	// 		// 	'z-index': '60',
	// 		// 	'padding-left':'0'
	// 		// });
	// 	}
	// });

	$('#message-box-json').hide();
	$('#message-box').fadeIn();
	$('#message-box .action-message .flash-message-success').parent().parent().parent().delay(7000).fadeOut();
	$('#message-box .action-message .flash-message-error').parent().parent().parent().delay(14000).fadeOut();
	$('#message-box-json').find('.section').empty();
	$(document).on('click','#message-box .close-message', function() {
		$(document).find('#message-box').hide();
	});
	$(document).on('click','#message-box-json .close-message', function() {
		$(document).find('#message-box-json').hide();
	});

	// keyboard action to cancel user add form
	$(document).on('keyup','#content form input', function(ev) {
		// hide if press esc
		if ( ev.keyCode == 27 ) {
			$(document).find('.create-something-form').slideUp(400,function(){
				$(document).find('.create-something-form').remove();
				$('#page-nav_menu .create-something-new .add-button').removeClass('active');
				$('.add-button').each(function(){
					$(this).prop('disabled', false);
				});
			});
		}
	});

	/* Admin Page */
	// Add New User
	// add datepicker to user form
	$('#admin-page form.update-user input.anniversary').datepicker();
	
	$(document).on('click','#page-nav_menu #admin-new-user-form .add-button',function(){
		$('.add-button').each(function(){
			$(this).prop('disabled',true);
		});
		$('.inner-page').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
		$.get( "/admin/users", function( data ) {
			$('.add-button').each(function(){
				$(this).prop('disabled',true);
			});
			$('.inner-page').before(data);
			$(document).find('.loading-something-new').remove();
			$('.user-add-form.create-something-form').slideDown(400);
			$('#page-nav_menu #admin-new-user-form.create-something-new .add-button').addClass('active');
			$('form.add-user .first-name').focus();
		});
	});
	// cancel user add form
	$(document).on('click','#content .user-add-form span.cancel',function(){
				$(document).find('.user-add-form.create-something-form').slideUp(400,function(){
					$(document).find('.user-add-form.create-something-form').remove();
					$('#page-nav_menu #admin-new-user-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
				});
		$('#message-box-json').find('.section').empty();
		$('#message-box-json').fadeOut();
	});
	// add user ajax submit
	$(document).on('submit', '#content .user-add-form form.add-user', function(){
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
					window.location.href = '/admin/users?user=new';
				}
			},'json'
		);
		return false;
	});
	// add new template
	$(document).on('click', '#page-nav_menu #admin-new-template-form .add-button', function(){
		$('.add-button').each(function(){
			$(this).prop('disabled',true);
		});
		$('.inner-page').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
		$.get( "/admin/templates", function( data ) {
			$('.add-button').each(function(){
				$(this).prop('disabled',true);
			});
			$('.inner-page').before(data);
			$(document).find('.loading-something-new').remove();
			$('.template-add-form.create-something-form').slideDown(400);
			$('#page-nav_menu #admin-new-template-form.create-something-new .add-button').addClass('active');
			$('form.add-template .template-name').focus();
			// $('span.cancel').each(function(){
			// 	$(this).addClass('ss-delete');
			// });
			// $('button.save').each(function(){
			// 	$(this).addClass('ss-uploadcloud');
			// });
		});
	});
	// add additional tasks to New Template form
	$(document).on('click','#content form.add-template .add-task-one', function() {
		$(this).closest('.new-form-field').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
		$.get( "/admin/templates/add-task", function( data ) {
			$(document).find('#content form.add-template .add-task-buttons').before(data);
			$(document).find('#content form.add-template .loading-something-new').remove();
		});
	});
	$(document).on('click','#content form.add-template .add-task-five', function() {
		$(this).closest('.new-form-field').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
		for (var i = 1; i <= 5; i++) {
			$.get( "/admin/templates/add-task", function( data ) {
				$(document).find('#content form.add-template .add-task-buttons').before(data);
			$(document).find('#content form.add-template .loading-something-new').remove();
			});
		};
	});
	$(document).on('click','#content form.add-template .add-task-ten', function() {
		$(this).closest('.new-form-field').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
		for (var i = 1; i <= 10; i++) {
			$.get( "/admin/templates/add-task", function( data ) {
				$(document).find('#content form.add-template .add-task-buttons').before(data);
			$(document).find('#content form.add-template .loading-something-new').remove();
			});
		};
	});
	$(document).on('click','#content form.add-template .add-task', function() {
		$(this).closest('.new-form-field').after('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
		$.get( "/admin/templates/add-task", function( data ) {
			$(document).find('#content form.add-template .loading-something-new').after(data);
			$(document).find('#content form.add-template .loading-something-new').remove();
		});
	});
	// remove task from New Template form
	$(document).on('mouseover','#content form.add-template .remove-task', function() {
		$(this).closest('.new-form-field').prev().css('background','#333333');
		$(this).closest('.new-form-field').prev().prev().css('background','#333333');
	});
	$(document).on('mouseout','#content form.add-template .remove-task', function() {
		$(this).closest('.new-form-field').prev().css('background','#555555');
		$(this).closest('.new-form-field').prev().prev().css('background','#555555');
	});
	$(document).on('click','#content form.add-template .remove-task', function() {
		$(this).closest('.new-form-field').prev().remove();
		$(this).closest('.new-form-field').prev().remove();
		$(this).closest('.new-form-field').remove();
	});
	// cancel template add
	$(document).on('click','#content form.add-template span.cancel',function(){
				$(document).find('.template-add-form.create-something-form').slideUp(400,function(){
					$(document).find('.template-add-form.create-something-form').remove();
					$('#page-nav_menu #admin-new-template-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
				});
		$('#message-box-json').find('.section').empty();
		$('#message-box-json').fadeOut();
	});
	// add template ajax submit
	
	$(document).on('submit','#content form.add-template', function() {
		var newTemplateOptions = { 
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       templateAddSuccess,  // post-submit callback
			dataType: 'json', 
			resetForm: false        // reset the form after successful submit 
		};
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
	    $(this).ajaxSubmit(newTemplateOptions);
	    return false;
	});
	function templateAddSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-success">'+data.msg+'</span></div>');
		   	window.location.href = '/admin/templates?template=new';
		}
	}
	// add additional tasks to Edit Template form
	// $(document).on('click','#content form.update-template .add-task-one', function() {
	// 	$.get( "/admin/templates/add-task", function( data ) {
	// 		$(document).find('#content form.update-template .add-task-buttons').before(data);
	// 	});
	// });
	// $(document).on('click','#content form.update-template .add-task-five', function() {
	// 	for (var i = 1; i <= 5; i++) {
	// 		$.get( "/admin/templates/add-task", function( data ) {
	// 			$(document).find('#content form.update-template .add-task-buttons').before(data);
	// 		});
	// 	};
	// });
	// $(document).on('click','#content form.update-template .add-task-ten', function() {
	// 	for (var i = 1; i <= 10; i++) {
	// 		$.get( "/admin/templates/add-task", function( data ) {
	// 			$(document).find('#content form.update-template .add-task-buttons').before(data);
	// 		});
	// 	};
	// });
	// // remove task from Edit Template form
	// $(document).on('click','#content form.update-template .remove-task', function() {
	// 	$(this).closest('.new-form-field').prev().css('background','#d5d5d5');
	// });
	//preview templates on admin page
	// on list view page
	// $('#admin-page .post-preview').hover(function(){
	// 	$(this).find('.ss-view').html('<small>Preview Template</small>');
	// },function(){
	// 	$(this).find('.ss-view').html('');
	// });
	// $(document).on('click', '#admin-page .post-preview', function(){
	// 	var templateId = $(this).attr('id');
	// 	$(document).find("#template-output-"+templateId).toggle();
	// });
	// on single view page
	// $(document).on('click', '#page-nav_menu #admin-preview-template-form .preview-template', function(){
	// 	$(".template-output").show();
	// });
	// close template previews
	// $(document).on('click', '#admin-page .close-template-preview', function(){
	// 	$(".template-output").hide();
	// });
	// $(document).on('click', '#admin-page .template-output h3', function() {
	// 	$(this).parent().find('.checklist-checkbox-section').toggle();
	// 	$(this).toggleClass('ss-directright');
	// 	$(this).toggleClass('ss-dropdown');
	// });
	// $(document).on('click', '.form-textarea-buttons .template-code', function(){
	// 	var ping = $(this).attr('id');
	// 	//console.log(ping);
	//     $('textarea.template-items').insertAtCaret(ping+'\n');
	// });
	/************/

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
	
	/* News Page */
	// target selected text (save for later)
	// var getSelected = function(){
	//     var t = '';
	//     if(window.getSelection) {
	//         t = window.getSelection();
	//     } else if(document.getSelection) {
	//         t = document.getSelection();
	//     } else if(document.selection) {
	//         t = document.selection.createRange().text;
	//     }
	//     return '<span>'+t+'</span>';
	// }

	// $(document).on('select','#article-content', function(eventObject) {
	//     console.log(getSelected().toString());
	//     // var textChange = getSelected().toString();
	//     // console.log(eventObject);
	//     // $(document).on('click', '.make-bold', function(textChange) {
	//     // 	console.log(textChange);
	//     // });
	// });

	// Favorite Articles
	// dashboard
	// $('#news-dashboard-page span.ss-heart').hover(function(){
	// 	$(this).find('span.favorite-this').removeClass('none');
	// }, function(){
	// 	$(this).find('span.favorite-this').addClass('none');
	// });
	$('#news-dashboard-page span.ss-heart.favorited').find('.favorite-this').html('Unfavorite Article');
	$(document).on('click', '#news-dashboard-page span.ss-heart', function(){
		var articleId = $(this).find('.favorite-this').attr('favoriteval');
		//console.log(articleId);
		$.post(
			$('#news-dashboard-page form#favorite-article-'+articleId).prop('action'),
			{
				"_token" : $('#news-dashboard-page form#favorite-article-'+articleId).find('input[name=_token]').val(),
				"favorite" : $('#news-dashboard-page form#favorite-article-'+articleId).find('input[name=favorite]').val(),
			}, function (data) {
				if(data.nofav) {
					$('#news-dashboard-page #favorite-'+articleId).removeClass('favorited');
					$('#news-dashboard-page #favorite-'+articleId).find('.favorite-this').html('Favorite Article');
				}
				else {
					$('#news-dashboard-page #favorite-'+articleId).addClass('favorited');
					$('#news-dashboard-page #favorite-'+articleId).find('.favorite-this').html('Unfavorite Article');
				}
			},'json'
		);
		return false;
	});
	// news page
	$('#news-page .ss-heart').hover(function(){
		$(this).find('.favorite-this').removeClass('none');
	}, function(){
		$(this).find('.favorite-this').addClass('none');
	});
	$('#news-page .ss-heart.favorited').find('.favorite-this').html('Unfavorite Article');
	$(document).on('click', '#news-page .ss-heart', function(){
		var articleId = $(this).find('.favorite-this').attr('favoriteval');
		//console.log(articleId);
		$.post(
			$('#news-page form#favorite-article-'+articleId).prop('action'),
			{
				"_token" : $('#news-page form#favorite-article-'+articleId).find('input[name=_token]').val(),
				"favorite" : $('#news-page form#favorite-article-'+articleId).find('input[name=favorite]').val(),
			}, function (data) {
				if(data.nofav) {
					$('#news-page #favorite-'+articleId).removeClass('favorited');
					$('#news-page #favorite-'+articleId).find('.favorite-this').html('Favorite Article');
				}
				else {
					$('#news-page #favorite-'+articleId).addClass('favorited');
					$('#news-page #favorite-'+articleId).find('.favorite-this').html('Unfavorite Article');
				}
			},'json'
		);
		return false;
	});
	// favorite articles
	$('#page-nav_menu .ss-heart').hover(function(){
		$(this).find('.favorite-this').show();
	}, function(){
		$(this).find('.favorite-this').hide();
	});
	$('#page-nav_menu .ss-heart.favorited').find('.favorite-this').html('Unfavorite Article');
	$(document).on('click', '#page-nav_menu .ss-heart', function(){
		var articleId = $(this).find('.favorite-this').attr('favoriteval');
		//console.log(articleId);
		$.post(
			$('#page-nav_menu form#favorite-article-'+articleId).prop('action'),
			{
				"_token" : $('#page-nav_menu form#favorite-article-'+articleId).find('input[name=_token]').val(),
				"favorite" : $('#page-nav_menu form#favorite-article-'+articleId).find('input[name=favorite]').val(),
			}, function (data) {
				if(data.nofav) {
					$('#page-nav_menu #favorite-'+articleId).removeClass('favorited');
					$('#page-nav_menu #favorite-'+articleId).find('.favorite-this').html('Favorite Article');
				}
				else {
					$('#page-nav_menu #favorite-'+articleId).addClass('favorited');
					$('#page-nav_menu #favorite-'+articleId).find('.favorite-this').html('Unfavorite Article');
				}
			},'json'
		);
		return false;
	});
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
	$('#content .office-post').hover(function() {
		$(this).find('.post-hover-content').show();
	}, function() {
		$(this).find('.post-hover-content').hide();
	});
	// Add new article
	$(document).on('click','#page-nav_menu #news-new-article-form .add-button',function(){
		$('.add-button').each(function(){
			$(this).prop('disabled',true);
		});
		$('.inner-page').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."> Loading Form...</span>');
		$.get( "/news", function( data ) {
			$('.add-button').each(function(){
				$(this).prop('disabled',true);
			});
			$('.inner-page').before(data);
			$(document).find('.loading-something-new').remove();
			$('#content .article-add-form.create-something-form').slideDown(400);
			$('#page-nav_menu #news-new-article-form.create-something-new .add-button').addClass('active');

			var calTemp = new Date();
		    var calNow = new Date(calTemp.getFullYear(), calTemp.getMonth(), calTemp.getDate(), 0, 0, 0, 0);
		    var calPost = $('#content form.add-article .article-calendar-date').datepicker({
		      onRender: function(date) {
		        return date.valueOf() < calNow.valueOf() ? 'disabled' : '';
		      }
		    }).on('changeDate', function(ev) {
		    	calPost.hide();
		    	$(this).addClass('changed-input');
		    }).data('datepicker');
		    
			$('form.add-article .article-title').focus();
		});
	});
	// detect Status change and update submit button text
	$(document).on('change', 'form.add-article select[name=status]', function(){
		var selectVal = $(this).val();
		var submitText = $(this).find('option[value='+selectVal+']').text();
		$('form.add-article').find('input#add-new-submit').val(submitText);
	});
	// cancel adding new form
	$(document).on('click','#content .article-add-form span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Save as draft to keep changes or continue to discard changes. Continue?');
		
			if(confirmCancel == true) {
				$(document).find('.article-add-form.create-something-form').slideUp(400,function(){
					$(document).find('.article-add-form.create-something-form').remove();
					$('#page-nav_menu #news-new-article-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
				});
				$('#message-box-json').find('.section').empty();
				$('#message-box-json').fadeOut();
			}
		}
		else {
			$(document).find('.article-add-form.create-something-form').slideUp(400,function(){
				$(document).find('.article-add-form.create-something-form').remove();
					$('#page-nav_menu #news-new-article-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
			});
			$('#message-box-json').find('.section').empty();
			$('#message-box-json').fadeOut();
		}
	});
	// submit new article
	var addArticleOptions = { 
		target:   '#message-box-json .section',   // target element(s) to be updated with server response 
		success:       afterAddArticleSuccess,  // post-submit callback 
		resetForm: false        // reset the form after successful submit 
	};	        
	$(document).on('submit','#content .article-add-form form.add-article', function() {
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
	    $(this).ajaxSubmit(addArticleOptions);
	    console.log('submit');
	    return false; 
	});
	function afterAddArticleSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-success">'+data.msg+'</span></div>');
		    //console.log('success');
			window.location.href = '/news/article/'+data.slug;
		}
	}
	// add pingable names to content textarea of new aritcle
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
		//console.log(ping);
	    $('textarea.article-content').insertAtCaret(ping);
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
	// add Delete option to attachments on Edit article page
	$('#news-page .post-edit-attachment').hover(function(){
		$(this).append('<span class="ss-delete delete-attachment"></span>');
	}, function(){
		$(this).find('.delete-attachment').remove();
	});
	// delete attachment with ajax and reload Edit article page
	$(document).on('click', '#news-page .post-edit-attachment', function() {
		var confirmCancel = confirm('Are you sure you want to delete this attachment?');
		
		if(confirmCancel == true) {
			var imageName = $(this).find('a img').attr('alt');
			var imagePath = $(this).find('a').attr('href');
			var imageId = $(this).parent().parent().find('form.update-article').attr('id');
			var imageToken = $(this).parent().parent().find('form.update-article input[name=_token]').val();
			$.post(
				'/news/article/'+imageId+'/remove/'+imageName,
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
	$(document).on('submit','#news-page form.delete-article', function() {
		var confirmCancel = confirm('Are you sure you want to delete this post?');
		
		if(confirmCancel == true) return true;
		else return false;
	});
	// on Submit of Edit article page, remove any changed-input classes.
	$(document).on('submit', '#news-page form.update-article', function(){
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
	});
	
	// load comment form on article single view page.
	$(document).on('click', '#news-page #news-post-comment-form .post-comment', function(){
		$('.post-comment').each(function(){
			$(this).prop('disabled',true);
		});
		$('#comments').after('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
		var articleSlug = $(document).find('.news-article').attr('slug');
		//console.log(articleSlug);
		$.get( "/news/article/"+articleSlug+"/comment", function( data ) {
			$('#comments').append(data);
			$(document).find('.loading-something-new').remove();
			$('#comments .news-article-new-comment.create-something-form').slideDown(400);
			$('#comments .news-article-new-comment.create-something-form').addClass('reply-to-article-form');
			$('.news-article-new-comment.create-something-form input[name=article-slug]').val(articleSlug);
			$('.post-comment').each(function(){
				$(this).prop('disabled',true);
			});
			$('#content #news-post-comment-form.create-something-new .add-button').addClass('active');
			$('#content form.add-comment .comment-content').focus();
		});
	});
	// cancel news article reply
	$(document).on('click','#news-page .news-article-new-comment span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Save as draft to keep changes or continue to discard changes. Continue?');
		
			if(confirmCancel == true) {
				$(document).find('.news-article-new-comment.create-something-form').slideUp(400,function(){
					$(document).find('.news-article-new-comment.create-something-form').remove();
					$('#content #news-post-comment-form.create-something-new .add-button').removeClass('active');
					$('.post-comment').each(function(){
						$(this).prop('disabled', false);
					});
				});
				$('#message-box-json').find('.section').empty();
				$('#message-box-json').fadeOut();
			}
		}
		else {
				$(document).find('.news-article-new-comment.create-something-form').slideUp(400,function(){
					$(document).find('.news-article-new-comment.create-something-form').remove();
					$('#content #news-post-comment-form.create-something-new .add-button').removeClass('active');
					$('#content #comment-post-comment-form.create-something-new .add-button').removeClass('active');
					$('.post-comment').each(function(){
						$(this).prop('disabled', false);
					});
				});
			$('#message-box-json').find('.section').empty();
			$('#message-box-json').fadeOut();
		}
	});
	// submit reply to article
	var articleCommentOptions = { 
		target:   '#message-box-json .section',   // target element(s) to be updated with server response 
		success:       postCommentSuccess,  // post-submit callback 
		resetForm: false        // reset the form after successful submit 
	};	        
	$(document).on('submit','#news-page .news-article-new-comment.reply-to-article-form form.add-comment', function() {
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
	    $(this).ajaxSubmit(articleCommentOptions);
	    return false;
	});
	function postCommentSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-success">'+data.msg+'</span></div>');
		    //console.log(data.comment_id);
			window.location.href = '/news/article/'+data.slug+'?comment=new#comment-'+data.comment_id;
			if(window.location.search == '?comment=new') window.location.reload(true);
		}
	}
	// add pingable names to content textarea of new comment
	$(document).on('click', '.form-textarea-buttons .ping', function(){
		var ping = $(this).attr('id');
		//console.log(ping);
	    $('textarea.comment-content').insertAtCaret(ping);
	});
	// load comment form on reply of comment button click
	$(document).on('click', '#news-page #comment-post-comment-form .post-comment', function(){
		$('.post-comment').each(function(){
			$(this).prop('disabled',true);
		});
		var articleSlug = $(document).find('.news-article').attr('slug');
		var commentId = $(this).closest('.office-post-comment').attr('id');
		var commentHeight = $(this).closest('.office-post-comment').height();
		var commentAuthor = $(document).find('#'+commentId+' .comment-author').attr('author');
		commentHeight = commentHeight-15;
		$('#'+commentId).after('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."></span>');
		// console.log(commentAuthor);
		$.get( "/news/article/"+articleSlug+"/comment", function( data ) {
			
			$('#'+commentId).after(data);
			$(document).find('.loading-something-new').remove();
			$('#content .news-article-new-comment.create-something-form').slideDown(400);
			$('#content .news-article-new-comment.create-something-form').addClass('reply-to-comment-form');
			$('.news-article-new-comment.create-something-form input[name=article-slug]').val(articleSlug);
			$('.post-comment').each(function(){
				$(this).prop('disabled',true);
			});
			$('#'+commentId).find('#comment-post-comment-form.create-something-new .add-button').addClass('active');
			$('#content .news-article-new-comment.create-something-form h3').html('Reply to '+commentAuthor+'\'s comment:');
			$('#content form.add-comment .comment-content').focus();
		});
	});
	// submit comment on a comment
	$(document).on('submit','#news-page .news-article-new-comment.reply-to-comment-form form.add-comment', function() {
		var commentReplyToId = $(document).find('#news-page .news-article-new-comment.reply-to-comment-form').prev().attr('id');
		// console.log(commentReplyToId);
		if(commentReplyToId) commentReplyToId = commentReplyToId.replace('comment-','');
		else commentReplyToId = 0;
		// submit reply to comment
		var commentCommentOptions = {
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       commentCommentSuccess,  // post-submit callback 
			resetForm: false,        // reset the form after successful submit 
			data: { reply_to_id: commentReplyToId }
		};
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
		$(this).ajaxSubmit(commentCommentOptions);
	    return false; 
	});
	function commentCommentSuccess(data)
	{
		if(data.errorMsg) {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
		}
		else {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-success">'+data.msg+'</span></div>');
		   	//console.log(data.slug);
			window.location.href = '/news/article/'+data.slug+'?comment=new#comment-'+data.comment_id;
			if(window.location.search == '?comment=new') window.location.reload(true);
		}
	}
	// edit comment
	$(document).on('click', '#news-page .comment-edit-button a.edit-comment', function(){
		
		var articleSlug = $(document).find('.news-article').attr('slug');
		
		var commentIdBox = $(this).closest('.office-post-comment').attr('id');
		var commentId = commentIdBox.replace('comment-','');
		//console.log(commentId);
		$.get( "/news/article/comment/"+commentId+"/edit", function( data ) {
			$(document).find('#news-page .comment-edit-button a.edit-comment').each(function(){
				$(this).hide();
			});
			$(document).find('#comment-post-comment-form .post-comment').each(function(){
				$(this).hide();
			});
			$('#'+commentIdBox+' .comment-contents').html(data);
			$('#'+commentIdBox+' .edit-something-form').fadeIn();
			$('#'+commentIdBox+' .comment-contents').find('input[name=article-slug]').val(articleSlug);
			$('form.edit-comment .update-comment-content').focus();
		});
	});
	// cancel editing a comment
	$(document).on('click','#news-page form.edit-comment span.cancel',function(){
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
	$(document).on('submit','#news-page form.edit-comment #update-comment', function() {
		var editCommentOptions = { 
			target:   '#message-box-json .section',   // target element(s) to be updated with server response 
			success:       commentEditSuccess,  // post-submit callback 
			resetForm: false        // reset the form after successful submit 
		};	 
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
	    $(this).ajaxSubmit(editCommentOptions);
	    return false;
	});
	function commentEditSuccess(data)
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
	// add pingable names to content textarea of new comment
	$(document).on('click', '.form-textarea-buttons .ping', function(){
		var ping = $(this).attr('id');
		//console.log(ping);
	    $('textarea.update-comment-content').insertAtCaret(ping);
	});
	// add option to delete attachment
	$(document).on('mouseenter', '#news-page .comment-edit-attachment', function(){
		$(this).append('<span class="ss-delete delete-attachment"></span>');
	});
	$(document).on('mouseleave', '#news-page .comment-edit-attachment', function(){
		$(this).find('.delete-attachment').remove();
	});
	// delete comment attachment with ajax
	$(document).on('click', '#news-page .comment-edit-attachment', function() {
		var confirmCancel = confirm('Are you sure you want to delete this attachment?');
		
		if(confirmCancel == true) {
			var imageName = $(this).find('a img').attr('alt');
			var imagePath = $(this).find('a').attr('href');
			var imageId = $(this).closest('.office-post-comment').attr('id');
			imageId = imageId.replace('comment-','');
			var imageToken = $(this).closest('form.edit-comment').find('input[name=_token]').val();
			$.post(
				'/news/article/comment/'+imageId+'/remove/'+imageName,
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
	
	// set min height of comments with attachments
	$('#content .office-post-comment .comment-contents').each(function() {
		if($(this).find('span.comment-single-attachment').length) $(this).css('min-height','145px');
	});

	/* Calendar Page */
	// $('.page-menu input.calendar-jump-to-date').datepicker().on('changeDate', function(ev) {
	// 	$('.dropdown-menu').hide();
	// 	var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
	// 	var dateLink = new Date(ev.date.valueOf());
	// 	var yearLink = dateLink.getFullYear();
	// 	var monthLink = months[dateLink.getMonth()];
	// 	window.location.href='/calendar/'+yearLink+'/'+monthLink;
	// });
	$('#page-nav_menu div.calendar-jump-to-date.calendar-filter').datepicker().on('changeDate', function(ev) {
		$('.dropdown-menu').hide();
		var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
		var dateLink = new Date(ev.date.valueOf());
		var yearLink = dateLink.getFullYear();
		var monthLink = months[dateLink.getMonth()];
		window.location.href='/calendar/'+yearLink+'/'+monthLink;
	});
	// $(document).on('click', '#page-nav_menu .key-desc', function() {
	// 	var toggleThis = $(this).attr('toggleval');
	// 	$(this).find('.key-color').toggleClass('disabled');
	// 	$('#calendar-page').find('.'+toggleThis).toggle();
	// });
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
			$(document).find('div#project-'+projectID+' .post-date .change-project-date').html('Due Date: <br />'+data.date+'<span class="project-change-date ss-write"></span>');
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
	var calProjListPost = $('#content .office-post .change-project-date').datepicker({
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
			$(document).find('div#project-'+projectID+' .post-date .change-project-date').html('Due Date: <br />'+data.date+'<span class="project-change-date ss-write"></span>');
			$(document).find('div#project-'+projectID).removeClass('due-soon');
			$(document).find('div#project-'+projectID).removeClass('due-now');
			$(document).find('div#project-'+projectID).addClass(data.changeclass);
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
			$(document).find('div#project-'+projectID+' .post-subscribed div').first().before('<div class="user-subscribed ss-delete" value="'+data.sub+'">'+data.subName+'</div>');
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
		var doneProgressWidth = 200/totalCheckboxes;
		var divProgressWidth = $(document).find('#page-nav_menu .post-progress .post-progress-progress').width();
		var saveTask = '';
		$(this).removeClass('changed-input');
		if (checkboxCheck.is(':checked'))
		{
			$(document).find('#page-nav_menu .post-progress .post-progress-progress-zero').first().remove();
			$(document).find('#page-nav_menu .post-progress-progress').append('<span class="post-progress-progress-done"></span>');
			$(document).find('#page-nav_menu .post-progress-complete').html(progressComplete+1);
			$(document).find('#page-nav_menu .post-progress .post-progress-progress-done').css('width',doneProgressWidth+'px');
			$(document).find('#page-nav_menu .post-progress .post-progress-progress').css('width',divProgressWidth+doneProgressWidth+'px');
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

				$(document).find('#page-nav_menu .post-progress .post-progress-progress-done').first().remove();
				$(document).find('#page-nav_menu .post-progress-complete').html(progressComplete-1);
				$(document).find('#page-nav_menu .post-progress .post-progress-progress').css('width',divProgressWidth-doneProgressWidth+'px');
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
					console.log(nextProjectStage);
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
		var doneProgressWidth = 200/totalCheckboxes;
		var divProgressWidth = $(document).find('#page-nav_menu .post-progress .post-progress-progress').width();
		$(this).removeClass('changed-input');

		$(document).find('#page-nav_menu .post-progress .post-progress-progress-zero').first().remove();
		$(document).find('#page-nav_menu .post-progress-progress').append('<span class="post-progress-progress-done"></span>');
		$(document).find('#page-nav_menu .post-progress-complete').html(progressComplete+1);
		$(document).find('#page-nav_menu .post-progress .post-progress-progress-done').css('width',doneProgressWidth+'px');
		$(document).find('#page-nav_menu .post-progress .post-progress-progress').css('width',divProgressWidth+doneProgressWidth+'px');
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
	// add new Project
	$(document).on('click','#page-nav_menu #projects-new-project-form .add-button',function(){
		$('.add-button').each(function(){
			$(this).prop('disabled',true);
		});
		$('.inner-page').before('<span class="loading-something-new"><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."> Loading Form...</span>');
		$.get( "/projects", function( data ) {
			$('.inner-page').before(data);
			$(document).find('.loading-something-new').remove();
			$('#content .project-add-form.create-something-form').slideDown(400);
			$('.add-button').each(function(){
				$(this).prop('disabled',true);
			});
			$('#page-nav_menu #projects-new-project-form.create-something-new .add-button').addClass('active');
			$('#content form.add-project input[name=title]').focus();

			var calTemp = new Date();
		    var calNow = new Date(calTemp.getFullYear(), calTemp.getMonth(), calTemp.getDate(), 0, 0, 0, 0);
		    var calLaunch = $('#content form.add-project .project-launch-date').datepicker({
		      onRender: function(date) {
		        return date.valueOf() < calNow.valueOf() ? 'disabled' : '';
		      }
		    }).on('changeDate', function(ev) {
		    	calLaunch.hide();
		    	$(this).addClass('changed-input');
		    	var launchVal = $(this).val();
		    	$(this).parent().parent().find('input[name=end_date]').attr('value',launchVal);
		    }).data('datepicker');
		    var calStart = $('#content form.add-project .project-start-date').datepicker({
		      onRender: function(date) {
		        return date.valueOf() < calNow.valueOf() ? 'disabled' : '';
		      }
		    }).on('changeDate', function(ev) {
		    	calStart.hide();
		    	$(this).addClass('changed-input');
		    }).data('datepicker');
		    var calEnd = $('#content form.add-project .project-end-date').datepicker({
		      onRender: function(date) {
		        return date.valueOf() < calNow.valueOf() ? 'disabled' : '';
		      }
		    }).on('changeDate', function(ev) {
		    	calEnd.hide();
		    	$(this).addClass('changed-input');
		    	var endVal = $(this).val();
		    	$(this).parent().parent().find('input[name=launch_date]').attr('value',endVal);
		    }).data('datepicker');
		    
			$('form.add-project .projects-title').focus();
			$('form.add-project .project-start-date').hide();
			$('form.add-project label[for=start_date]').hide();
			$('form.add-project .project-end-date').hide();
			$('form.add-project label[for=end_date]').hide();
			$(document).on('change','form.add-project select[name=period]', function() {
				var periodValue = $(this).val();
				if(periodValue == 'recurring') {
					$('form.add-project .project-launch-date').hide();
					$('form.add-project label[for=launch_date]').hide();
					$('form.add-project .project-launch-date').val('');
					$('form.add-project .project-start-date').fadeIn(200);
					$('form.add-project label[for=start_date]').fadeIn(200);
					$('form.add-project .project-end-date').fadeIn(200);
					$('form.add-project label[for=end_date]').fadeIn(200);
				}
				else {
					$('form.add-project .project-end-date').val('');
					$('form.add-project .project-start-date').hide();
					$('form.add-project label[for=start_date]').hide();
					$('form.add-project .project-end-date').hide();
					$('form.add-project label[for=end_date]').hide();
					$('form.add-project .project-launch-date').fadeIn(200);	
					$('form.add-project label[for=launch_date]').fadeIn(200);				
				}
			});

			// active search of accounts
			$(document).on('input','form.add-project .search-accounts', function() {
				var accountSearch = $(this).val();
				$(document).find('form.add-project .accounts-search-ajax').show().html('<span><img src="/images/ajax-snake-loader-grey.gif" alt="Loading..."> Searching...</span>');
				if(accountSearch.length >= 3) {
					// search accounts and return a list
					var accountSearchOptions = { 
						target:   '.accounts-search-ajax',   // target element(s) to be updated with server response 
						success:       accountSearchSuccess,  // post-submit callback
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
					$(this).ajaxSubmit(accountSearchOptions);
					return false;
				}
				else {
					$(document).find('form.add-project .accounts-search-ajax').show().html('<span>Please type at least 3 characters to start a search.</span>');
				}
			});
			$(document).on('click','form.add-project .accounts-search-ajax span', function() {
				var accountID = parseInt($(this).attr('value'),10);
				var accountText = $(this).text();
				$(this).closest('form.add-project').find('input[name=account_name]').val(accountText);
				$(this).closest('form.add-project').find('input[name=account_id]').attr('value',accountID);
				$(document).find('form.add-project .accounts-search-ajax').hide();
			});

			// add template name from id to form
			$(document).on('change','form.add-project select[name=template_id]', function(){
				var templateIdGet = $(this).val();
				var templateIdName = $(this).find('option[value='+templateIdGet+']').text();
				$(this).parent().next('input[name=template_name]').val(templateIdName);
			});
		});
	});
	function accountSearchSuccess(data)
	{
		if(data.msg == 'found some') {
			$(document).find('form.add-project .accounts-search-ajax').show().html(data.accounts);
		}
		else {
			$(document).find('form.add-project .accounts-search-ajax').show().html('<span>No accounts found.</span>');
		}
	}
	// cancel adding new project
	$(document).on('click','#content .project-add-form span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Continue to discard changes. Continue?');
		
			if(confirmCancel == true) {
				$(document).find('.project-add-form.create-something-form').slideUp(400,function(){
					$(document).find('.project-add-form.create-something-form').remove();
					$('#page-nav_menu #projects-new-project-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
				});
				$('#message-box-json').find('.section').empty();
				$('#message-box-json').fadeOut();
			}
		}
		else {
			$(document).find('.project-add-form.create-something-form').slideUp(400,function(){
				$(document).find('.project-add-form.create-something-form').remove();
					$('#page-nav_menu #projects-new-project-form.create-something-new .add-button').removeClass('active');
					$('.add-button').each(function(){
						$(this).prop('disabled', false);
					});
			});
			$('#message-box-json').find('.section').empty();
			$('#message-box-json').fadeOut();
		}
	});
	// submit new project
	var addProjectOptions = { 
		target:   '#message-box-json .section',   // target element(s) to be updated with server response 
		success:       afterAddProjectSuccess,  // post-submit callback 
		resetForm: false        // reset the form after successful submit 
	};	        
	$(document).on('submit','#content .project-add-form form.add-project', function() {
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
	    $(this).ajaxSubmit(addProjectOptions);
	    //console.log('submit');
	    return false; 
	});
	function afterAddProjectSuccess(data)
	{
		if(data.errorMsg) {
			if(data.errorMsg == 'The account id field is required.') {
				$('#message-box-json').fadeIn();
				$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">Please select an Account.</span></div>');
			}
			else if(data.errorMsg == 'The template id field is required.') {
				$('#message-box-json').fadeIn();
				$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">Please select a Template.</span></div>');
			}
			else {
				$('#message-box-json').fadeIn();
				$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
			}
		}
		else {
			$('#message-box-json').fadeIn();
			$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-success">'+data.msg+'</span></div>');
		    //console.log('success');
			window.location.href = '/projects/post/'+data.slug;
		}
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
		if(accountSearch.length >= 3) {
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
		else {
			$(document).find('form.update-project .accounts-search-ajax').show().html('<span>Please type at least 3 characters to start a search.</span>');
		}
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
		}
		else {
			$(document).find('form.update-project .accounts-search-ajax').show().html('<span>No accounts found.</span>');
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
	$(document).on('click', '#projects-page #projects-post-comment-form button.post-comment', function(){
		$('button.post-comment').each(function(){
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
			$('button.post-comment').each(function(){
				$(this).prop('disabled',true);
			});
			$('#content #projects-post-comment-form.create-something-new .anchor-button').addClass('active');
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
					$('#content #projects-post-comment-form.create-something-new .anchor-button').removeClass('active');
					$('button.post-comment').each(function(){
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
					$('#content #projects-post-comment-form.create-something-new .anchor-button').removeClass('active');
					$('#content #comment-post-comment-form.create-something-new .anchor-button').removeClass('active');
					$('button.post-comment').each(function(){
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
	$(document).on('click', '#projects-page #comment-post-comment-form button.post-comment', function(){
		$('button.post-comment').each(function(){
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
			$('button.post-comment').each(function(){
				$(this).prop('disabled',true);
			});
			$('#'+commentId).find('#comment-post-comment-form.create-something-new .anchor-button').addClass('active');
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
		if($(this).hasClass('projects-filter') ) return;
		if($(this).hasClass('todo-filter') ) return;
		if($(this).hasClass('checklist-checkbox') ) return;
		if($(this).attr('class') == 'calendar-jump-to-date') return;
		if($(this).parent().parent().attr('class') == 'login-form') return;
		if($(this).parent().parent().attr('class') == 'login-remind') return;
		if($(this).parent().parent().attr('class') == 'login-reset') return;
		if($(this).parent().attr('class') == 'office-search') return;
		if($(this).closest('.template-output').attr('class') == 'template-output') return;
		if($(this).attr('class') == 'change-project-user-list') return;
		if($(this).attr('class') == 'change-project-manager-list') return;
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