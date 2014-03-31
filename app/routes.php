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
Route::get('/',array('as' => 'dashboard', 'uses' => 'DashboardController@index'))->before('auth');

Route::get('login',array('as' => 'login', 'uses' => 'SessionsController@create'));
Route::get('logout','SessionsController@destroy');
Route::resource('sessions','SessionsController',array('only' => array('create','store','destroy') ));

Route::controller('password', 'RemindersController');

Route::get('/admin',array('as' => 'admin', 'uses' => 'AdminController@index'))->before('auth');
Route::post( '/admin', array( 'uses' => 'AdminController@userToUpdate' ) );
//Route::resource('admin','AdminController');

Route::get('/profile/{usersname}',array('as' => 'user.profile', 'uses' => 'UsersController@show'))->before('auth');
Route::post('/profile/{usersname}',array('uses' => 'UsersController@update'))->before('auth');

Route::get('/projects', function(){
	return View::make('projects.index');
})->before('auth');

Route::get('/tools', function(){
	return View::make('tools.index');
})->before('auth');

App::missing(function($exception)
{
    if(Auth::guest()) return Redirect::route('login');
    else return;
});