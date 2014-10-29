<?php

// Event::listen('illuminate.query', function($query){
// 	var_dump($query);
// });

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
/* Dashboard */
Route::get('/', array('as' => 'dashboard', 'uses' => 'DashboardController@index'));

/* Login */
Route::get('login', array('as' => 'login', 'uses' => 'SessionsController@create'));
Route::get('logout','SessionsController@destroy');
Route::resource('sessions','SessionsController', array('only' => array('index','create','store','destroy')));

Route::controller('password', 'RemindersController');

/* To-Do */
Route::get('/to-do', array('uses' => 'TodoController@noUser'));
Route::get('/to-do/{userpath}', array('as' => 'todo', 'uses' => 'TodoController@index'));

/* Admin */
Route::get('/admin', array('as' => 'admin', 'uses' => 'AdminController@index'));
Route::get('/admin/users', array('as' => 'admin.users', 'uses' => 'AdminController@users'));
Route::delete('/admin/users', array('as' => 'admin.userDelete', 'uses' => 'AdminController@userDelete'));
Route::get('/admin/users/create', array('as' => 'admin.userCreate', 'uses' => 'AdminController@userCreate'));
Route::post('/admin/users/store', array('as' => 'admin.userNew', 'uses' => 'AdminController@userNew'));
Route::get('/admin/users/{userpath}', array('as' => 'admin.userEdit', 'uses' => 'AdminController@userEdit'));
Route::post('/admin/users/{userpath}', array('as' => 'admin.userUpdate', 'uses' => 'AdminController@userUpdate'));
Route::get('/admin/templates', array('as' => 'admin.templates', 'uses' => 'AdminController@templates'));
Route::get('/admin/templates/create', array('as' => 'admin.templateCreate', 'uses' => 'AdminController@templateCreate'));
Route::post('/admin/templates/store', array('as' => 'admin.templateNew', 'uses' => 'AdminController@templateNew'));
Route::post('/admin/templates/{id}', array('as' => 'admin.templateUpdate', 'uses' => 'AdminController@templateUpdate'));
Route::get('/admin/templates/add-task', array('uses' => 'AdminController@templateAddtask'));
Route::get('/admin/templates/{template}/edit', array('uses' => 'AdminController@templateEdit'));

/* Profile */
Route::get('/profile/', array('as' => 'profile', 'uses' => 'ProfilesController@show'));
Route::post('/profile/vacation', array('as' => 'profile.vacation', 'uses' => 'ProfilesController@vacation'));
Route::get('/profile/edit', array('as' => 'profile.edit', 'uses' => 'ProfilesController@edit'));
Route::post('/profile/update', array('as' => 'profile.update', 'uses' => 'ProfilesController@update'));

/* Uploads */
Route::get('/uploads/{year}/{month}/{name}',array('as' => 'uploads', 'uses' => 'UploadsController@show'));

/* News */
Route::get('/news', array('as' => 'news','uses' => 'ArticlesController@index'));
Route::post('/news', array('as' => 'news.articleNew','uses' => 'ArticlesController@store'));
Route::get('/news/create', array('as' => 'news.articleCreate','uses' => 'ArticlesController@create'));
Route::get('/news/article/{article}', array('as' => 'news.article', 'uses' => 'ArticlesController@show'));
Route::get('/news/article/{article}/comment', array('as' => 'news.articleComment', 'uses' => 'ArticleCommentsController@show'));
Route::post('/news/article/{article}/comment', array('uses' => 'ArticleCommentsController@store'));
Route::get('/news/article/comment/{id}/edit', array('uses' => 'ArticleCommentsController@edit'));
Route::post('/news/article/comment/{id}', array('uses' => 'ArticleCommentsController@update'));
Route::post('/news/article/comment/{id}/remove/{imageName}', array('uses' => 'ArticleCommentsController@removeImage'));
Route::get('/news/article/{article}/edit', array('uses' => 'ArticlesController@edit'));
Route::post('/news/article/{article}', array('uses' => 'ArticlesController@update'));
Route::delete('/news/article/{id}', array('uses' => 'ArticlesController@destroy'));
Route::post('/news/article/{id}/remove/{imageName}', array('uses' => 'ArticlesController@removeImage'));
Route::get('/news/author/{author}', array('as' => 'news.authorFilter', 'uses' => 'ArticlesController@authorFilter'));
Route::get('/news/unread/', array('as' => 'news.unreadFilter', 'uses' => 'ArticlesController@unreadFilter'));
Route::get('/news/mentions/', array('as' => 'news.mentionsFilter', 'uses' => 'ArticlesController@mentionsFilter'));
Route::get('/news/favorites/', array('as' => 'news.favoritesFilter', 'uses' => 'ArticlesController@favoritesFilter'));
Route::post('/news/favorites/{id}', array('as' => 'news.favoriteArticle', 'uses' => 'ArticlesController@favoriteArticle'));
Route::get('/news/drafts/', array('as' => 'news.draftsFilter', 'uses' => 'ArticlesController@draftsFilter'));
Route::get('/news/date/{year}/{month}', array('as' => 'news.dateFilter', 'uses' => 'ArticlesController@dateFilter'));

/* Calendar */
Route::get('/calendar', array('as' => 'calendar', 'uses' => 'CalendarsController@index'));
Route::get('/calendar/{year}/{month}', array('as' => 'calendar.month', 'uses' => 'CalendarsController@show'));

/* Projects */
Route::get('/projects', array('as' => 'projects', 'uses' => 'ProjectsController@index'));
Route::post('/projects', array('as' => 'projects.projectNew','uses' => 'ProjectsController@store'));
Route::post('/projects/listviewupdate/{id}/{value}', array('as' => 'projects.updateOnListView', 'uses' => 'ProjectsController@updateOnListView'));
Route::post('/projects/singleviewupdate/{id}/{value}', array('as' => 'projects.updateOnSingleView', 'uses' => 'ProjectsController@updateOnSingleView'));
Route::get('/projects/assigned-to/{userpath}', array('as' => 'projects.assignedTo', 'uses' => 'ProjectsController@assignedTo'));
Route::get('/projects/date/{year}/{month}', array('as' => 'projects.dateFilter', 'uses' => 'ProjectsController@dateFilter'));
Route::get('/projects/priority/{priority}', array('as' => 'projects.priorityFilter', 'uses' => 'ProjectsController@priorityFilter'));
Route::get('/projects/status/{status}', array('as' => 'projects.statusFilter', 'uses' => 'ProjectsController@statusFilter'));
Route::get('/projects/type/{type}/stage/{stage}', array('as' => 'projects.stageFilter', 'uses' => 'ProjectsController@stageFilter'));
Route::get('/projects/type/{type}', array('as' => 'projects.typeFilter', 'uses' => 'ProjectsController@typeFilter'));
Route::get('/projects/post/{project}', array('as' => 'projects.project', 'uses' => 'ProjectsController@show'));
Route::get('/projects/post/{project}/edit', array('uses' => 'ProjectsController@edit'));
Route::post('/projects/post/{project}', array('uses' => 'ProjectsController@update'));
Route::post('/projects/post/{id}/remove/{imageName}', array('uses' => 'ProjectsController@removeImage'));
Route::delete('/projects/post/{id}', array('uses' => 'ProjectsController@destroy'));
Route::get('/projects/post/{project}/comment', array('as' => 'projects.projectComment', 'uses' => 'ProjectCommentsController@show'));
Route::post('/projects/post/{project}/comment', array('uses' => 'ProjectCommentsController@store'));
Route::get('/projects/post/comment/{id}/edit', array('uses' => 'ProjectCommentsController@edit'));
Route::post('/projects/post/comment/{id}', array('uses' => 'ProjectCommentsController@update'));
Route::post('/projects/post/comment/{id}/remove/{imageName}', array('uses' => 'ProjectCommentsController@removeImage'));

/* Acounts */
Route::post('/accounts/search/{title}',array('as' => 'accounts.search', 'uses' => 'AccountsController@search'));
Route::get('/accounts',array('as' => 'accounts', 'uses' => 'AccountsController@index'));
Route::get('/accounts/{accountname}',array('as' => 'account.profile', 'uses' => 'AccountsController@show'));
Route::get('/account-new/',array('as' => 'account.new', 'uses' => 'AccountsController@create'));

/* Assets */
Route::get('/assets', array('as' => 'assets', 'uses' => 'AssetsController@index'));
Route::get('/assets/status', array('as' => 'assets.status', 'uses' => 'AssetsController@statusPage'));
Route::post('/assets/vault/access', array('as' => 'assets.vaultAccess', 'uses' => 'VaultController@vaultAccess'));
Route::get('/assets/vault', array('as' => 'assets.vault', 'uses' => 'VaultController@index'));
Route::post('/assets/vault', array('as' => 'assets.vaultNew','uses' => 'VaultController@store'));
Route::get('/assets/vault/asset/{slug}', array('as' => 'assets.vaultAsset', 'uses' => 'VaultController@show'));
Route::get('/assets/vault/tags/{tag}', array('as' => 'assets.vaultTags', 'uses' => 'VaultController@tags'));
Route::delete('/assets/vault/asset/{id}', array('uses' => 'VaultController@destroy'));

/* Tags */
Route::post('/tags/search/{title}',array('as' => 'tags.search', 'uses' => 'TagsController@search'));
Route::get('/tags', array('as' => 'tags', 'uses' => 'TagsController@index'));
Route::post('/tags/newtag/{newtag}', array('as' => 'tags.newtag', 'uses' => 'TagsController@store'));
Route::get('/tags/recent', array('as' => 'tags.recent', 'uses' => 'TagsController@recent'));
Route::get('/tags/type/{type}', array('as' => 'tags.type', 'uses' => 'TagsController@type'));
//Route::get('/tags/popular', array('as' => 'tags.popular', 'uses' => 'TagsController@popular'));
Route::get('/tags/letter/{letter}', array('as' => 'tags.letter', 'uses' => 'TagsController@letter'));
Route::get('/tags/name/{tagname}', array('as' => 'tags.tag', 'uses' => 'TagsController@show'));

// This section is just for dummy pages. Will need to convert Routes to point to Controllers.
Route::get('/billables', function(){
	if(Request::ajax()) return View::make('billables.partials.new');
	else return View::make('billables.index');
})->before('auth');

Route::get('/invoices', function(){
	if(Request::ajax()) return View::make('invoices.partials.new');
	return View::make('invoices.index');
})->before('auth');

Route::get('/help', function(){
	if(Request::ajax()) return View::make('help.partials.new');
	else return View::make('help.index');
})->before('auth');


Route::get('/emails', function(){
	$mgClient = new Mailgun('key-8f6lpwb2tgnp3se2b6fli18r23ndpkt9');
	$mgDomain = 'iout.co';
	$queryString = array('event' => 'stored');
	$result = $mgClient->get("$mgDomain/events", $queryString);
	//dd($result);
	if($result->http_response_body->items) $mgKey = $result->http_response_body->items[0]->storage->key;
	else return 'no emails';
		
	//dd($mgKey);
	try {
		$email = $mgClient->get("domains/$mgDomain/messages/$mgKey");
		dd($email);
	} catch(Mailgun \ Connection \ Exceptions \ MissingEndpoint $e)
	{
		return 'no emails';
	}
	//$deleteStored = $mgClient->delete("domains/$mgDomain/messages/$mgKey");
		
})->before('auth');
// End dummy pages section

/* Custom 404 Page */
App::missing(function($exception)
{
    if(Auth::guest()) return Redirect::route('login');
    else return Response::view('errors.missing');
});