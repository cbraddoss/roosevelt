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
Route::resource('sessions','SessionsController', array('only' => array('create','store','destroy')));

Route::controller('password', 'RemindersController');

/* To-Do */
Route::get('/to-do', array('uses' => 'TodoController@noUser'));
Route::get('/to-do/{userpath}', array('as' => 'todo', 'uses' => 'TodoController@index'));

/* Admin */
Route::get('/admin', array('as' => 'admin', 'uses' => 'AdminController@index'));
Route::get('/admin/users', array('as' => 'admin.users', 'uses' => 'AdminController@users'));
Route::post('/admin/users', array('as' => 'admin.userNew', 'uses' => 'AdminController@userNew'));
Route::delete('/admin/users', array('as' => 'admin.userDelete', 'uses' => 'AdminController@userDelete'));
Route::get('/admin/users/{userpath}', array('as' => 'admin.userEdit', 'uses' => 'AdminController@userEdit'));
Route::post('/admin/users/{userpath}', array('as' => 'admin.userUpdate', 'uses' => 'AdminController@userUpdate'));
Route::get('/admin/templates', array('as' => 'admin.templates', 'uses' => 'AdminController@templates'));
Route::post('/admin/templates', array('as' => 'admin.templateNew', 'uses' => 'AdminController@templateNew'));
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

/* Tools */
Route::get('/tools', function(){
	return View::make('tools.index');
})->before('auth');

// This section is just for dummy pages. Will need to convert Routes to point to Controllers.
Route::get('/billables', function(){
	if(Request::ajax()) return View::make('billables.partials.new');
	else return View::make('billables.index');
})->before('auth');

Route::get('/invoices', function(){
	return View::make('invoices.index');
})->before('auth');

Route::get('/help', function(){
	if(Request::ajax()) return View::make('help.partials.new');
	else return View::make('help.index');
})->before('auth');

Route::get('/wiki', function(){
	if(Request::ajax()) return View::make('wiki.partials.new');
	else return View::make('wiki.index');
})->before('auth');
// End dummy pages section

/* Custom 404 Page */
App::missing(function($exception)
{
    if(Auth::guest()) return Redirect::route('login');
    else return Response::view('errors.missing');
});