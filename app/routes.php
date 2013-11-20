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

// Show home page
Route::get('/', 'HomeController@showHome');
// For home page AJAX query
Route::post('show-photos', array(
    'uses' => 'HomeController@showPhotos',
    'as' => 'home.photos'
));
/*--------------------------------------------------------------------------------------------------------------------*/
// Show user profile page
Route::get('/profile', 'HomeController@showProfile');
/*--------------------------------------------------------------------------------------------------------------------*/
// Show albums page
Route::get('/albums', 'HomeController@showAlbums');
Route::post('albums-get', array(
    'uses' => 'AlbumsController@getData',
    'as' => 'albums.get'
));
/*--------------------------------------------------------------------------------------------------------------------*/
// Show single album page
Route::get('albums/{albumId}', 'HomeController@showSingleAlbum');
Route::post('upload-and-show-photos', array(
    'uses' => 'AlbumController@getData',
    'as' => 'photo.upload'
));
Route::post('edit-album-info', array(
    'uses' => 'AlbumController@editAlbum',
    'as' => 'album.edit'
));
Route::post('comment-album', array(
    'uses' => 'AlbumController@editAlbum',
    'as' => 'album.comment'
));
//Ajax
Route::post('delete-photo', 'AlbumController@deletePhoto');
Route::post('delete-album', 'AlbumController@deleteAlbum');
Route::post('like-album', 'AlbumController@makeLike');
/*--------------------------------------------------------------------------------------------------------------------*/
// Show single photo page
Route::get('/singlephoto', 'HomeController@showSinglePhoto');
/*--------------------------------------------------------------------------------------------------------------------*/
// Show login page
Route::get('login', 'HomeController@showLogin');
Route::post('login', array(
    'uses' => 'LoginController@authLogin',
    'as' => 'login'
));
/*--------------------------------------------------------------------------------------------------------------------*/

// Logout route
Route::get('logout', function() {
    Auth::logout();
    return Redirect::to('login');
});