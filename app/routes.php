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
Route::get('/', array('as' => 'dashboard', 'uses' => 'DashboardController@index'));

Route::get('login', array('as' => 'login', 'uses' => 'SessionsController@create'));
Route::get('logout','SessionsController@destroy');
Route::resource('sessions','SessionsController', array('only' => array('create','store','destroy')));

Route::controller('password', 'RemindersController');

Route::get('/admin', array('as' => 'admin', 'uses' => 'AdminController@index'));
Route::get('/admin/users', array('as' => 'admin.users', 'uses' => 'AdminController@users'));
Route::post('/admin/users', array('as' => 'admin.userNew', 'uses' => 'AdminController@userNew'));
Route::delete('/admin/users', array('as' => 'admin.userDelete', 'uses' => 'AdminController@userDelete'));
Route::get('/admin/users/{userpath}', array('as' => 'admin.userEdit', 'uses' => 'AdminController@userEdit'));
Route::post('/admin/users/{userpath}', array('as' => 'admin.userUpdate', 'uses' => 'AdminController@userUpdate'));
Route::get('/admin/templates', array('as' => 'admin.templates', 'uses' => 'AdminController@templates'));

Route::get('/profile/', array('as' => 'profile', 'uses' => 'ProfilesController@show'));
Route::get('/profile/edit', array('as' => 'profile.edit', 'uses' => 'ProfilesController@edit'));
Route::post('/profile/update', array('as' => 'profile.update', 'uses' => 'ProfilesController@update'));

Route::get('/news', array('as' => 'news','uses' => 'ArticlesController@index'));
Route::post('/news', array('as' => 'news.articleNew','uses' => 'ArticlesController@store'));
Route::get('/news/article/{article}', array('as' => 'news.article', 'uses' => 'ArticlesController@show'));
Route::get('/news/article/{article}/edit', array('uses' => 'ArticlesController@edit'));
Route::post('/news/article/{article}', array('uses' => 'ArticlesController@update'));
Route::get('/news/author/{author}', array('as' => 'news.authorFilter', 'uses' => 'ArticlesController@authorFilter'));
Route::get('/news/unread/', array('as' => 'news.unreadFilter', 'uses' => 'ArticlesController@unreadFilter'));
Route::get('/news/mentions/', array('as' => 'news.mentionsFilter', 'uses' => 'ArticlesController@mentionsFilter'));
Route::get('/news/favorites/', array('as' => 'news.favoritesFilter', 'uses' => 'ArticlesController@favoritesFilter'));
Route::post('/news/favorites/{id}', array('as' => 'news.favoriteArticle', 'uses' => 'ArticlesController@favoriteArticle'));
Route::get('/news/drafts/', array('as' => 'news.draftsFilter', 'uses' => 'ArticlesController@draftsFilter'));
Route::get('/news/date/{year}/{month}', array('as' => 'news.dateFilter', 'uses' => 'ArticlesController@dateFilter'));

// Route::get('/tools', function(){
// 	return View::make('tools.index');
// })->before('auth');

// // This section is just for dummy pages. Will need to convert Routes to point to Controllers.
// Route::get('/projects', function(){
// 	return View::make('projects.index');
// })->before('auth');

// Route::get('/billables', function(){
// 	return View::make('billables.index');
// })->before('auth');

// Route::get('/invoices', function(){
// 	return View::make('invoices.index');
// })->before('auth');

// Route::get('/accounts',array('as' => 'accounts', 'uses' => 'AccountsController@index'))->before('auth');
// Route::get('/accounts/{accountname}',array('as' => 'account.profile', 'uses' => 'AccountsController@show'))->before('auth');
// Route::get('/account-new/',array('as' => 'account.new', 'uses' => 'AccountsController@create'))->before('auth');

// Route::get('/calendar', function(){
// 	return View::make('calendar.index');
// })->before('auth');

// Route::get('/help', function(){
// 	return View::make('help.index');
// })->before('auth');

// Route::get('/wiki', function(){
// 	return View::make('wiki.index');
// })->before('auth');
// // End dummy pages section


App::missing(function($exception)
{
    if(Auth::guest()) return Redirect::route('login');
    else return Response::view('errors.missing');
});