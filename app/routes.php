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

Route::resource('/admin','AdminController', array('only' => array('index') ) );
// //Route::get('/admin', array('as' => 'admin', 'uses' => 'AdminController@index'));
// //Route::post( '/admin', array( 'uses' => 'AdminController@userToUpdate' ));
// //Route::get( '/admin/check', array( 'uses' => 'AdminController@check' ));

//Route::resource('/profile','ProfilesController', array('only' => array('index','store','edit') ) );
Route::get('/profile/', array('as' => 'profile', 'uses' => 'ProfilesController@show'));
Route::get('/profile/edit', array('as' => 'profile.edit', 'uses' => 'ProfilesController@edit'));
Route::post('/profile/update', array('as' => 'profile.update', 'uses' => 'ProfilesController@update'));
//Route::post('/profile/',array('uses' => 'UsersController@update'))->before(array('csrf','auth'));

// Route::get('/news', array('as' => 'news','uses' => 'ArticlesController@index'))->before('auth');
// Route::get('/news/article/{article}', array('uses' => 'ArticlesController@show'))->before('auth');
// Route::get('/news/author/{author}', array('as' => 'news.authorFilter', 'uses' => 'ArticlesController@authorFilter'))->before('auth');
// Route::get('/news/unread/', array('as' => 'news.unreadFilter', 'uses' => 'ArticlesController@unreadFilter'))->before('auth');
// Route::get('/news/date/{year}/{month}', array('as' => 'news.dateFilter', 'uses' => 'ArticlesController@dateFilter'))->before('auth');

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