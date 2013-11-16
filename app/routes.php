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

// Show main page
Route::get('/', 'HomeController@showHome');

// Show user profile page
Route::get('/profile', 'HomeController@showProfile');

// Show albums page
Route::get('/albums', 'HomeController@showAlbums');
Route::post('albums-get', array(
    'uses' => 'AlbumsController@getData',
    'as' => 'albums.get'
));

// Show single album page
//Route::get('/singlealbum', 'HomeController@showSingleAlbum');
Route::get('albums/{albumId}', 'HomeController@showSingleAlbum');
Route::post('upload-photo-to-album', array(
    'uses' => 'AlbumController@getData',
    'as' => 'photo.upload'
));

Route::get('/singlephoto', 'HomeController@showSinglePhoto');

// Show login page
Route::get('login', 'HomeController@showLogin');
Route::post('login', array(
    'uses' => 'LoginController@authLogin',
    'as' => 'login'
));

// Logout route
Route::get('logout', function() {
    Auth::logout();
    return Redirect::to('login');
});