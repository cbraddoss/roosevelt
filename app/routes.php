<?php

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

Route::get('login',['as' => 'login', 'uses' => 'SessionsController@create']);
Route::get('logout','SessionsController@destroy');
Route::resource('sessions','SessionsController',['only' => ['create','store','destroy'] ]);

Route::controller('password', 'RemindersController');

Route::get('/admin',['as' => 'admin', 'uses' => 'AdminController@index'])->before('auth');

App::missing(function($exception)
{
    if(Auth::guest()) return Redirect::route('login');
    else return;
});