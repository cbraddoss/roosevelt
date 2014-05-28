jQuery(document).ready(function($){
	$("a[href $= 'gif'],a[href $= 'jpg'],a[href $= 'jpeg'],a[href $= 'JPG'],a[href $= 'JPEG'],a[href $= 'PNG'],a[href $= 'png']").colorbox({ opacity: '0.6',maxHeight:'80%', maxWidth: '80%' });
	
	//Animate scroll to loaded comment id
	var commentUrlHash = window.location.hash;
	var commentUrlNew = window.location.search;
	//console.log(commentUrlNew);
	var commentGoToPost = $(commentUrlHash).offset();
	if(commentGoToPost) {
		$('html, body').animate({
			scrollTop: commentGoToPost.top-110
		}, 2000);
	}
	if(commentUrlNew == '?comment=new') {
		$(commentUrlHash).find('.comment-contents').css({
			'background': 'rgba(75,131,180,0.2)'
		});
	}
	//Update active status of a menu link (both top menu bar and user menu bar)
	var currentPage = window.location.pathname;
	currentPage = currentPage.replace("/", "");
	currentPage = currentPage.split('/');
	$('#menu_links').find('li.link').each(function(){
		var linkActiveMain = $(this).attr('id');
		linkActiveMain = linkActiveMain.replace("link-", "");
		$(this).removeClass('active');
		if(currentPage.indexOf(linkActiveMain) >= 0 ) $(this).addClass('active');
		if(currentPage == '' && linkActiveMain == 'dashboard') $(this).addClass('active');
	});
	var zIndex = 80;
	$('#menu_links .link').each(function(){
		$(this).css('z-index',zIndex);
		zIndex = zIndex-1;
	});
	// show arrow for sub menu on specific main menu item
	var activeMenuItem = $(document).find('#menu_header ul#menu_links li.active').offset().left;
	var contentEdge = $(document).find('#content').offset().left;
	var activeMenuPos = activeMenuItem-contentEdge+40;
	$(document).find('#content .page-menu-arrow').css('margin-left', activeMenuPos+'px');
	
	// show sub menu on hover
	$('#menu_header ul#menu_links li.link').hover(function(){
		$(this).children('ul.sub_menu_links').css({
			'visibility': 'visible'
		}).fadeIn(400).show();
	},function(){
		$(this).children('ul.sub_menu_links').css({
			'visibility': 'hidden'
		}).hide();
	});

	$(".the_menu ul li.arrow").hover(function() { //When hovering...
		$(this).children("ul.subnav").slideDown(0400).show(); //Slide down
		$(this).children("ul.subnav").css('visibility', 'visible'); //bring back visibility while sliding down
	},
	function() {
		$(this).children("ul.subnav").css('visibility', 'hidden'); //instantly hide on mouseout
		$(this).children("ul.subnav").hide(); //Slide back up
	});
	$(".the_menu ul li").hover(function() { //When hovering...
		$(this).addClass("hovering"); 
	},
	function() {
		$(this).removeClass("hovering"); 
	});

	// $('#user-menu ul').find('li').each(function(){
	// 	var linkActiveUser = $(this).attr('id');
	// 	linkActiveUser = linkActiveUser.replace("link-", "");
	// 	$(this).removeClass('active');
	// 	if(currentPage.indexOf(linkActiveUser) >= 0 ) $(this).addClass('active');
	// });

	// var welcomes = new Array('Welcome','Willkommen','स्वागत','Bienvenue','歡迎光臨','Wëllkomm','Bienvenido','ようこそ','Welcome');
	// var i = 1;
	// if(currentPage == '') {
	// 	function welcomeLoop () {
	// 	   setTimeout(function () {
	// 		console.log(welcomes[i]);
	// 	      $('#user-menu #welcome-name .welcome').html(welcomes[i]);
	// 	      i++;
	// 	      if (i < 9) {
	// 	         welcomeLoop();
	// 	      }
	// 	   }, 10000)
	// 	}
	// 	welcomeLoop();
	// }

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
	
	$('#message-box-json').hide();
	$('#message-box').fadeIn();
	$('#message-box .action-message .flash-message-success').parent().parent().parent().delay(7000).fadeOut();
	$('#message-box .action-message .flash-message-error').parent().parent().parent().delay(14000).fadeOut();
	$('#message-box-json').find('.section').empty();

	/* Admin Page */
	// Add New User
	$('#admin-page form.update-user input.anniversary').datepicker();
	$(document).on('click','#admin-page #admin-new-user-form button.add-new',function(){
		$.get( "/admin/users", function( data ) {
			$('#admin-new-user-form').html(data);
			$('form.add-user .first-name').focus();
		});
	});
	$(document).on('click','#admin-page .user-add-form span.cancel',function(){
		$('#admin-new-user-form').html('<span class="admin-button"><button class="add-new">Add New</button></span>');
		$('#message-box-json').find('.section').empty();
		$('#message-box-json').fadeOut();
	});
	$(document).on('keyup','#admin-page form.add-user input', function(ev) {
		// hide if press esc
		if ( ev.keyCode == 27 ) {
			$('#admin-new-user-form').html('<span class="admin-button"><button class="add-new">Add New</button></span>');
		}
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

	// favorite articles
	$('#news-page span.ss-heart').hover(function(){
		$(this).find('span.favorite-this').removeClass('none');
	}, function(){
		$(this).find('span.favorite-this').addClass('none');
	});
	$('#news-page span.ss-heart.favorited').find('.favorite-this').html('Unfavorite This Article');
	$(document).on('click', '#news-page span.ss-heart', function(){
		var articleId = $(this).find('.favorite-this').attr('favoriteval');
		$.post(
			$('#news-page #article-'+articleId+' form.favorite-article').prop('action'),
			{
				"_token" : $('#news-page #article-'+articleId+' form.favorite-article').find('input[name=_token]').val(),
				"favorite" : $('#news-page #article-'+articleId+' form.favorite-article').find('input[name=favorite]').val(),
			}, function (data) {
				if(data.nofav) {
					$('#news-page #article-'+articleId+' span.ss-heart').removeClass('favorited');
					$('#news-page span.ss-heart').find('.favorite-this').html('Favorite This Article');
				}
				else {
					$('#news-page #article-'+articleId+' span.ss-heart').addClass('favorited');
					$('#news-page span.ss-heart.favorited').find('.favorite-this').html('Unfavorite This Article');
				}
			},'json'
		);
		return false;
	});
	// Filter by author
	$(document).on('change','#news-page .filter-author', function(){
		var authorLink = $(this).val();
		window.location.href='/news/author/'+authorLink;
	});
	// Filter by date
	$('#news-page .filter-date').datepicker().on('changeDate', function(ev) {
		$('.dropdown-menu').hide();
		var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
		var dateLink = new Date(ev.date.valueOf());
		var yearLink = dateLink.getFullYear();
		var monthLink = months[dateLink.getMonth()];
		window.location.href='/news/date/'+yearLink+'/'+monthLink;
	});
	// Add new article
	$(document).on('click','#news-page #news-new-article-form button.add-new',function(){
		$.get( "/news", function( data ) {
			$('#news-new-article-form').html(data);

			var calTemp = new Date();
		    var calNow = new Date(calTemp.getFullYear(), calTemp.getMonth(), calTemp.getDate(), 0, 0, 0, 0);
		    var calPost = $('#news-page form.add-article .article-calendar-date').datepicker({
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
	$(document).on('click','#news-page .article-add-form span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Save as draft to keep changes or continue to discard changes. Continue?');
		
			if(confirmCancel == true) {
				$('#news-new-article-form').html('<span class="news-button"><button class="add-new">New Post</button></span>');
				$('#message-box-json').find('.section').empty();
				$('#message-box-json').fadeOut();
			}
		}
		else {
			$('#news-new-article-form').html('<span class="news-button"><button class="add-new">New Post</button></span>');
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
	$(document).on('submit','#news-page .article-add-form form.add-article', function() {
		$(this).find('.changed-input').each(function() {
			$(this).removeClass('changed-input');
		});
	    $(this).ajaxSubmit(addArticleOptions);
	    //console.log('submit');
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
	$('#news-page .article-edit-attachment').hover(function(){
		$(this).append('<span class="ss-delete"></span>');
	}, function(){
		$(this).find('.ss-delete').remove();
	});
	// delete attachment with ajax and reload Edit article page
	$(document).on('click', '#news-page .article-edit-attachment', function() {
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
	$(document).on('click', '#news-page #news-post-comment-form button.post-comment', function(){
		
		var pageName = $('body').attr('class');
		pageName = pageName.split(' ');
		pageName = pageName[0].replace('page-news-article-','');
		//console.log(pageName);
		$.get( "/news/article/"+pageName+"/comment", function( data ) {
			$('#news-post-comment-form').html(data);
			$('#news-post-comment-form input[name=article-slug]').val(pageName);
			$('form.add-comment .comment-content').focus();
		});
	});
	// cancel news article reply
	$(document).on('click','#news-page #news-post-comment-form span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Save as draft to keep changes or continue to discard changes. Continue?');
		
			if(confirmCancel == true) {
				$('#news-post-comment-form').html('<span class="news-button"><button class="post-comment">Reply</button></span>');
				$('#message-box-json').find('.section').empty();
				$('#message-box-json').fadeOut();
			}
		}
		else {
			$('#news-post-comment-form').html('<span class="news-button"><button class="post-comment">Reply</button></span>');
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
	$(document).on('submit','#news-page #news-post-comment-form form.add-comment', function() {
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
	$(document).on('click', '#news-page #comment-post-comment-form button.post-comment', function(){
		var pageName = $('body').attr('class');
		pageName = pageName.split(' ');
		pageName = pageName[0].replace('page-news-article-','');
		var commentId = $(this).closest('.office-post-comment').attr('id');
		var commentHeight = $(this).closest('.office-post-comment').height();
		commentHeight = commentHeight-15;
		//commentId = commentId.replace('comment-','');
		//console.log(commentId);
		$.get( "/news/article/"+pageName+"/comment", function( data ) {
			$(document).find('#comment-post-comment-form .post-comment').each(function(){
				$(this).hide();
			});
			$('#'+commentId+' .create-something-new').html(data);
			$('#'+commentId+' .create-something-new .create-something-form').css('top',commentHeight+'px');

			var commentBoxPos = $('#'+commentId).offset();
			$('html, body').animate({
				scrollTop: commentBoxPos.top-110
			}, 2000);
			$('#'+commentId+' .create-something-new').find('input[name=article-slug]').val(pageName);
			$('form.add-comment .comment-content').focus();
		});
	});
	// cancel comment reply
	$(document).on('click','#news-page #comment-post-comment-form form span.cancel',function(){
		var findChanged = $(document).find('.changed-input').length;
		if(findChanged > 0) {
			var confirmCancel = confirm('There are unsaved changes. Save as draft to keep changes or continue to discard changes. Continue?');
		
			if(confirmCancel == true) {
				$(this).closest('#comment-post-comment-form').html('<span class="comment-reply-button"><button class="post-comment">Reply</button></span>');
				$(document).find('#comment-post-comment-form .post-comment').each(function(){
					$(this).show();
				});
				$('#message-box-json').find('.section').empty();
				$('#message-box-json').fadeOut();
			}
		}
		else {
			$(this).closest('#comment-post-comment-form').html('<span class="comment-reply-button"><button class="post-comment">Reply</button></span>');
			$(document).find('#comment-post-comment-form .post-comment').each(function(){
				$(this).show();
			});
			$('#message-box-json').find('.section').empty();
			$('#message-box-json').fadeOut();
		}
	});
	// submit comment on a comment
	$(document).on('submit','#news-page #comment-post-comment-form form.add-comment', function() {
		var commentReplyToId = $(document).find('#news-page form.add-comment').closest('.office-post-comment').attr('id');
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
		   	console.log(data.slug);
			window.location.href = '/news/article/'+data.slug+'?comment=new#comment-'+data.comment_id;
			if(window.location.search == '?comment=new') window.location.reload(true);
		}
	}
	// edit comment
	$(document).on('click', '#news-page .comment-edit-button button.edit-comment', function(){
		var pageName = $('body').attr('class');
		pageName = pageName.split(' ');
		pageName = pageName[0].replace('page-news-article-','');
		
		var commentIdBox = $(this).closest('.office-post-comment').attr('id');
		var commentId = commentIdBox.replace('comment-','');
		//console.log(commentId);
		///news/article/comment/{{ $subComment->id }}/edit
		$.get( "/news/article/comment/"+commentId+"/edit", function( data ) {
			$(document).find('#news-page .comment-edit-button button.edit-comment').each(function(){
				$(this).hide();
			});
			$(document).find('#comment-post-comment-form .post-comment').each(function(){
				$(this).hide();
			});
			$('#'+commentIdBox+' .comment-contents').html(data);
			$('#'+commentIdBox+' .comment-contents').find('input[name=article-slug]').val(pageName);
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
		   	console.log(data.comment_id);
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
		$(this).append('<span class="ss-delete"></span>');
	});
	$(document).on('mouseleave', '#news-page .comment-edit-attachment', function(){
		$(this).find('.ss-delete').remove();
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
						console.log(data.image);
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
	$('.page-menu input.calendar-jump-to-date').datepicker().on('changeDate', function(ev) {
		$('.dropdown-menu').hide();
		var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
		var dateLink = new Date(ev.date.valueOf());
		var yearLink = dateLink.getFullYear();
		var monthLink = months[dateLink.getMonth()];
		window.location.href='/calendar/'+yearLink+'/'+monthLink;
	});
	$(document).on('click', '#calendar-page .key-desc', function() {
		var toggleThis = $(this).attr('toggleval');
		$(this).find('.key-color').toggleClass('disabled');
		$('#calendar-page').find('.'+toggleThis).toggle();
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
		if($(this).attr('class') == 'calendar-jump-to-date') return;
		if($(this).parent().parent().attr('class') == 'login-form') return;
		if($(this).parent().parent().attr('class') == 'login-remind') return;
		if($(this).parent().parent().attr('class') == 'login-reset') return;
		if($(this).parent().attr('class') == 'office-search') return;
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