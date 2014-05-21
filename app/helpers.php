<?php
function body_class() {
	$currentPage = $_SERVER['REQUEST_URI'];
	$page = '';
	$currentPage = strtok($currentPage, '?');
	$currentPageArray = explode('/', $currentPage);
	foreach($currentPageArray as $cPage) {
		$page .= '-'.$cPage;
	}
	if(count($currentPageArray) > 2) {
		$mainPage = 'page-'.$currentPageArray[1];
		$mainPage = str_replace('--', '-', $mainPage);
	}
	else $mainPage = '';
	$page = 'page'.$page;
	$page = str_replace('--', '-', $page);
	$bodyClass = $page . ' ' . $mainPage;
	return $bodyClass;
}

function current_page() {
	$currentPage = $_SERVER['REQUEST_URI'];
	return $currentPage;
}

function gravatar_url($email,$size = '40') {
	return 'http://www.gravatar.com/avatar/' . md5($email) . '?s=' . $size . '&d=http%3A%2F%2Fassets.insideout.com%2Fimages%2Fuser-image.png';
}

function current_user_path() {
	return Auth::user()->user_path;
}

function any_user_path($id) {
	$user = User::find($id);
	return $user->user_path;
}

function find_user_from_path($userpath) {
	$user = User::where('user_path','=', $userpath)
			->first();
	return $user;
}

function get_user_list_select($selected = null) {
	$users = User::all();
	$options = '';
	foreach($users as $user) {
		if($selected == $user->first_name.' '.$user->last_name) $options .= '<option value="'.any_user_path($user->id).'" selected>'.$user->first_name.' '.$user->last_name.'</option>';
		else $options .= '<option value="'.any_user_path($user->id).'">'.$user->first_name.' '.$user->last_name.'</option>';
	}
	return $options;
}

function convert_title_to_path($title) {
	$title = trim($title);
	$title = str_replace(" ","-",$title);
	$title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
	$title = strip_tags($title);
	$title = strtolower($title);
	return $title;
}

function clean_title($title) {
	$title = htmlspecialchars(strip_tags(trim($title)));
	return ucwords($title);
}

function clean_content($content) {
	// convert script and php tags to pre tags
	
	$content = preg_replace('/<script(.*?)>/i', '<pre class="script">',$content);
	//$content = str_replace('<script>', '<pre class="script">', $content);
	$content = str_replace('</script>', '</pre>', $content);
	$content = str_replace('<?php', '<pre class="php">', $content);
	$content = str_replace('?>', '</pre>', $content);
	return htmlentities($content);
}

function display_content($content, $length = null) {
	if($length != null && strlen($content) >= 100 ) return nl2br(substr(strip_tags(html_entity_decode($content)),0,$length)) . '......';
	// $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	// if(preg_match_all($reg_exUrl, $content, $url)) {
	// 	//dd($url);
	// 	foreach($url[0] as $href) {
	// 		$replacement = "<a href=".$href.">{$href}</a>";
 //            $content = str_replace($href,$replacement,$content);
	// 	}
	// }
	return nl2br(html_entity_decode($content));
}

function upload_path() {
	$attachYear = Carbon::now()->format('Y');
	$yearPath = storage_path().'/uploads/'.$attachYear;
	File::isDirectory($yearPath) or File::makeDirectory($yearPath);

	$attachMonth = Carbon::now()->format('m');
	$monthPath = storage_path().'/uploads/'.$attachYear.'/'.$attachMonth;
	File::isDirectory($monthPath) or File::makeDirectory($monthPath);

	$uploadPath = storage_path().'/uploads/'.$attachYear.'/'.$attachMonth.'/';

	return $uploadPath;
}

function find_mentions($content) {
	$mentionSearch = "/(@)((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))/is";
	$mention = '';
	if(preg_match_all($mentionSearch, $content, $mentionFound)) {
		$mentionFound = array_unique($mentionFound[0]);
		foreach($mentionFound as $mentionAdd) {
			$mentionAdd = str_replace('@', '', $mentionAdd);
			$mention .= $mentionAdd . ' ';
		}
	}
	if(strpos($content, '@insideout') !== false) $mention .= 'insideout';
	
	return $mention;
}

function article_ping_email($newArticle, $previousMentions = '') {
	$parseUsers = $newArticle->mentions;
	$parseUsers = explode(' ',$parseUsers);

	$parseOldUsers = $previousMentions;
	$parseOldUsers = explode(' ', $parseOldUsers);

	$findTasks = find_assigned_count('tasks');
	$findProjects = find_assigned_count('projects');
	$findBillables = find_assigned_count('billables');
	$findHelp = find_assigned_count('help');

	$users = array();
	foreach($parseUsers as $pUser) {
		if($pUser == '') unset($pUser);
		elseif(in_array($pUser, $parseOldUsers)) unset($pUser);
		else {
			$users[] = $pUser;
		}
	}

	foreach($users as $user) {
		if($user == 'insideout') {
			$userSend = '';
			$author = User::where('id', '=', $newArticle->author_id)->first();
			$pingDetails = array(
				'content' => '<p>You have been pinged by ' . $author->first_name . ' ' . $author->last_name . ' in <b>' . $newArticle->title . '</b></p>
	<p>View the post here: <a href="http://roosevelt.insideout.com/news/article/' . $newArticle->slug . '">' . $newArticle->title . '</a></p>
	<small>This post was created on ' . $newArticle->created_at->format('F j, Y g:i a') . '</small>'
				);
			Mail::send('emails.notifications.main', $pingDetails, function($message) use($userSend, $newArticle) {
				$message->from('office@insideout.com', 'InsideOut Employee Remote Office');
				$message->to('cbraddoss@gmail.com', 'InsideOut Solutions')->subject('You have been pinged in ' . $newArticle->title);
			});
		}
		else {
			$userSend = User::where('user_path','=',$user)->first();
			$author = User::where('id', '=', $newArticle->author_id)->first();
			$pingDetails = array(
				'content' => '<p>You have been pinged by ' . $author->first_name . ' ' . $author->last_name . ' in <b>' . $newArticle->title . '</b></p>
	<p>View the post here: <a href="http://roosevelt.insideout.com/news/article/' . $newArticle->slug . '">' . $newArticle->title . '</a></p>
	<small>This post was created on ' . $newArticle->created_at->format('F j, Y g:i a') . '</small>',
				'tasks' => $findTasks,
				'projects' => $findProjects,
				'billables' => $findBillables,
				'help' => $findHelp,
				);
			Mail::send('emails.notifications.main', $pingDetails, function($message) use($userSend, $newArticle) {
				$message->from('office@insideout.com', 'InsideOut Employee Remote Office');
				$message->to($userSend->email, $userSend->first_name . ' ' . $userSend->last_name)->subject('You have been pinged in ' . $newArticle->title);
			});
		}
	}
}

function article_comment_ping_email($newArticleComment, $previousMentions = '') {
	$parseUsers = $newArticleComment->mentions;
	$parseUsers = explode(' ',$parseUsers);

	$parseOldUsers = $previousMentions;
	$parseOldUsers = explode(' ', $parseOldUsers);

	// $findTasks = find_assigned_count('tasks');
	// $findProjects = find_assigned_count('projects');
	// $findBillables = find_assigned_count('billables');
	// $findHelp = find_assigned_count('help');
	$findTasks = '<span>??</span>';
	$findProjects = '<span>??</span>';
	$findBillables = '<span>??</span>';
	$findHelp = '<span>??</span>';

	$users = array();
	foreach($parseUsers as $pUser) {
		if($pUser == '') unset($pUser);
		elseif(in_array($pUser, $parseOldUsers)) unset($pUser);
		else {
			$users[] = $pUser;
		}
	}

	$articleWithComment = Article::find($newArticleComment->article_id);
	$authorComment = User::find($newArticleComment->author_id);
	$authorArticle = User::find($articleWithComment->author_id);
	$commentOfComment = ArticleComment::find($newArticleComment->reply_to_id);
	if($commentOfComment) {
		$authorCommentOnComment = User::find($commentOfComment->author_id);
	}
	else {
		$authorCommentOnComment = false;
		
	}

	if($authorCommentOnComment != false) {
		// send email to comment author
		if($authorCommentOnComment->id != $authorComment->id) {
			$pingCommentAuthorDetails = array(
				'content' => '<p>Your comment on <b>' . $articleWithComment->title . '</b> has a new reply by ' . $authorComment->first_name . ' ' . $authorComment->last_name . '</p>
	<p>View the comment here: <a href="http://roosevelt.insideout.com/news/article/' . $articleWithComment->slug . '?comment=new#comment-'.$newArticleComment->id . '">' . $articleWithComment->title . '</a></p>
	<small>This post was created on ' . $newArticleComment->created_at->format('F j, Y g:i a') . '</small>',
				'tasks' => $findTasks,
				'projects' => $findProjects,
				'billables' => $findBillables,
				'help' => $findHelp,
			);
			Mail::send('emails.notifications.main', $pingCommentAuthorDetails, function($message) use($authorCommentOnComment, $articleWithComment) {
				$message->from('office@insideout.com', 'InsideOut Employee Remote Office');
				$message->to($authorCommentOnComment->email, $authorCommentOnComment->first_name . ' ' . $authorCommentOnComment->last_name)->subject('Your comment on, '.$articleWithComment->title.', has a new reply.');
			});
		}

		// send email to article author
		if($authorCommentOnComment->id != $authorArticle->id) {
			$pingAuthorDetails = array(
				'content' => '<p>Your article, <b>' . $articleWithComment->title . '</b>, has a new reply by ' . $authorComment->first_name . ' ' . $authorComment->last_name . '</p>
	<p>View the comment here: <a href="http://roosevelt.insideout.com/news/article/'.$articleWithComment->slug.'?comment=new#comment-'.$newArticleComment->id . '">' . $articleWithComment->title . '</a></p>
	<small>This post was created on ' . $newArticleComment->created_at->format('F j, Y g:i a') . '</small>',
				'tasks' => $findTasks,
				'projects' => $findProjects,
				'billables' => $findBillables,
				'help' => $findHelp,
			);
			Mail::send('emails.notifications.main', $pingAuthorDetails, function($message) use($authorArticle, $articleWithComment) {
				$message->from('office@insideout.com', 'InsideOut Employee Remote Office');
				$message->to($authorArticle->email, $authorArticle->first_name . ' ' . $authorArticle->last_name)->subject('Your article, '.$articleWithComment->title.', has a new reply.');
			});
		}
	}
	else {
		// send email to article author
		if($authorComment->id != $authorArticle->id) {
			$pingAuthorDetails = array(
				'content' => '<p>Your article, <b>' . $articleWithComment->title . '</b>, has a new reply by ' . $authorComment->first_name . ' ' . $authorComment->last_name . '</p>
	<p>View the comment here: <a href="http://roosevelt.insideout.com/news/article/'.$articleWithComment->slug.'?comment=new#comment-'.$newArticleComment->id . '">' . $articleWithComment->title . '</a></p>
	<small>This post was created on ' . $newArticleComment->created_at->format('F j, Y g:i a') . '</small>',
				'tasks' => $findTasks,
				'projects' => $findProjects,
				'billables' => $findBillables,
				'help' => $findHelp,
			);
			Mail::send('emails.notifications.main', $pingAuthorDetails, function($message) use($authorArticle, $articleWithComment) {
				$message->from('office@insideout.com', 'InsideOut Employee Remote Office');
				$message->to($authorArticle->email, $authorArticle->first_name . ' ' . $authorArticle->last_name)->subject('Your article, '.$articleWithComment->title.', has a new reply.');
			});
		}
	}

	// send email(s) to pinged users
	foreach($users as $user) {
		if($user == 'insideout') {
			$userSend = '';
			$pingDetails = array(
				'content' => '<p>You have been pinged by ' . $authorComment->first_name . ' ' . $authorComment->last_name . ' in <b>' . $articleWithComment->title . '</b></p>
	<p>View the comment here: <a href="http://roosevelt.insideout.com/news/article/'.$articleWithComment->slug.'?comment=new#comment-'.$newArticleComment->id . '">' . $articleWithComment->title . '</a></p>
	<small>This post was created on ' . $newArticleComment->created_at->format('F j, Y g:i a') . '</small>',
				'tasks' => $findTasks,
				'projects' => $findProjects,
				'billables' => $findBillables,
				'help' => $findHelp,
			);
			Mail::send('emails.notifications.main', $pingDetails, function($message) use($userSend, $articleWithComment){
				$message->from('office@insideout.com', 'InsideOut Employee Remote Office');
				$message->to('cbraddoss@gmail.com', 'InsideOut Solutions')->subject('You have been pinged in ' . $articleWithComment->title);
			});
		}
		else {
			$userSend = User::where('user_path','=',$user)->first();
			$pingDetails = array(
				'content' => '<p>You have been pinged by ' . $authorComment->first_name . ' ' . $authorComment->last_name . ' in <b>' . $articleWithComment->title . '</b></p>
	<p>View the comment here: <a href="http://roosevelt.insideout.com/news/article/'.$articleWithComment->slug.'?comment=new#comment-'.$newArticleComment->id . '">' . $articleWithComment->title . '</a></p>
	<small>This post was created on ' . $newArticleComment->created_at->format('F j, Y g:i a') . '</small>',
				'tasks' => $findTasks,
				'projects' => $findProjects,
				'billables' => $findBillables,
				'help' => $findHelp,
			);
			Mail::send('emails.notifications.main', $pingDetails, function($message) use($userSend, $articleWithComment) {
				$message->from('office@insideout.com', 'InsideOut Employee Remote Office');
				$message->to($userSend->email, $userSend->first_name . ' ' . $userSend->last_name)->subject('You have been pinged in ' . $articleWithComment->title);
			});
		}
	}

}

function display_pingable() {
	$users = User::where('status','!=', 'inactive')->get();
	$pingable = '';
	$pingable .= '<span class="textarea-button ping" id="@insideout ">InsideOut</span>';
	foreach($users as $user) {
		$pingable .= '<span class="textarea-button ping" id="@' . $user->user_path . ' ">' . $user->first_name . ' ' . $user->last_name . '</span>';
	}
	return $pingable;
}

function find_unread_count($resource) {
	$currentUser = current_user_path();
	$lastMonth = new DateTime('-1 month');
	if($resource == 'articles') {
		$articles = Article::where('created_at','>=',$lastMonth)
					->where('been_read','not like','%'.$currentUser.'%')
					->where('status','!=','draft')
					->get()->count();
		if($articles != 0) return '<span class="linked-to">'.$articles.'</span>';
	}
	else return;
}

function find_assigned_count($resource) {
	$currentUser = current_user_path();
	// display projects assigned or part of per user not completed yet
	if($resource == 'projects') {
		$projects = '?!';
		return '<span class="linked-to">'.$projects.'</span>';
	}
	// display billables assigned per user not completed yet
	elseif($resource == 'billables') {
		$billables = '?!';
		return '<span class="linked-to">'.$billables.'</span>';
	}
	// display upcoming due dates per user for projects and tasks
	elseif($resource == 'calendar') {
		$calendar = '?!';
		return '<span class="linked-to">'.$calendar.'</span>';
	}
	// display help assigned per user not completed yet
	elseif($resource == 'help') {
		$help = '?!';
		return '<span class="linked-to">'.$help.'</span>';
	}
	// display taks assigned per user not completed yet
	elseif($resource == 'tasks') {
		$tasks = '?!';
		return '<span class="linked-to">'.$tasks.'</span>';
	}
	else return;
}

function user_last_login($login) {
	$login = new DateTime($login);
	$login = $login->format('F j, Y');
	if($login != 'November 30, -0001') return 'Last Login:<br/> '.$login;
	else return 'Login: null';
}
// Save for later
// function link_to_task(Task $task) {
// 	return link_to_route('user.tasks.show', $task->title, [$task->user->username, $task->id]);
// }