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

// Show main page - login page
Route::get('/', 'HomeController@showMain');

Route::get('login', 'HomeController@showLogin');
Route::post('login', function() {
    // get POST data
    $userdata = array(
        'username'      => Input::get('username'),
        'password'      => Input::get('password')
    );

    if ( Auth::attempt($userdata) )
    {
        // logged in, go to home
        return Redirect::to('/');
    }
    else
    {
        // auth failure, go back to the login
        return Redirect::to('login')->with('login_errors', true);
    }
});
Route::get('logout', function() {
    Auth::logout();
    return Redirect::to('login');
});

// Show user profile page
Route::get('/profile', 'HomeController@showProfile');

Route::get('/albums', 'HomeController@showAlbums');
Route::get('/singlealbum', 'HomeController@showSingleAlbum');
Route::get('/singlephoto', 'HomeController@showSinglePhoto');