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
	
	/* News Page */
	var getSelected = function(){
	    var t = '';
	    if(window.getSelection) {
	        t = window.getSelection();
	    } else if(document.getSelection) {
	        t = document.getSelection();
	    } else if(document.selection) {
	        t = document.selection.createRange().text;
	    }
	    return '<span>'+t+'</span>';
	}

	$(document).on('select','#article-content', function(eventObject) {
	    console.log(getSelected().toString());
	    // var textChange = getSelected().toString();
	    // console.log(eventObject);
	    // $(document).on('click', '.make-bold', function(textChange) {
	    // 	console.log(textChange);
	    // });
	});
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
			$('#news-page form.add-article .article-calendar-date').datepicker();
			$('form.add-article .article-title').focus();
		});
	});
	$(document).on('click','#news-page .article-add-form span.cancel',function(){
		$('#news-new-article-form').html('<span class="news-button"><button class="add-new">Add New</button></span>');
		$('#message-box-json').find('.section').empty();
		$('#message-box-json').fadeOut();
	});
	$(document).on('submit', '#news-page .article-add-form form.add-article', function(){
		$.post(
			$(this).prop('action'),
			{
				"_token" : $( this ).find( 'input[name=_token]' ).val(),
				"title" : $(this).find('input.article-title').val(),
				"content" : $(this).find('textarea.article-content').val(),
				"show_on_calendar" : $(this).find('input[name=show_on_calendar]').val(),
			}, function (data) {
				if(data.errorMsg) {
					$('#message-box-json').fadeIn();
					$('#message-box-json').find('.section').html('<div class="action-message"><span class="flash-message flash-message-error">' + data.errorMsg + '</span></div>');
				}
				else {
					$('#message-box-json').find('.section').empty();
					$('#message-box-json').fadeOut();
					window.location.href = '/news';
				}
			},'json'
		);
		return false;
	});
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
	console.log(ping);
    $('textarea.article-content').insertAtCaret(ping);
})

	/* Calendar Page */
	$('#sub-menu input.calendar-jump-to-date').datepicker().on('changeDate', function(ev) {
		$('.dropdown-menu').hide();
		var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
		var dateLink = new Date(ev.date.valueOf());
		var yearLink = dateLink.getFullYear();
		var monthLink = months[dateLink.getMonth()];
		window.location.href='/calendar/'+yearLink+'/'+monthLink;
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