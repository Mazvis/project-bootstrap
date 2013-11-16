<?php

class HomeController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    /**
     * Show home page
     */
    public function showHome() {
        $this->layout->content = View::make('home');

        $home = new Home();
        $photoUrlArray = $home->getPhotos();

        $this->layout->content->photos_url = $photoUrlArray;
    }

    /**
     * Show the user profile.
     */
    public function showProfile() {
        $this->layout->content = View::make('profile');
    }

    public function showLogin() {
        $this->layout->content = View::make('login');
    }

    public function showAlbums() {
        $this->layout->content = View::make('albums');
    }

    /*public function showSingleAlbum() {
        $this->layout->content = View::make('singlealbum');
    }*/
    public function showSingleAlbum($albumId)
    {
        $album = new AlbumController();
        $albumName = $album->getAlbumNameById($albumId);

        if($albumName){
            $album->setAlbumID($albumId); //for image upload
            $this->layout->content = View::make('singlealbum', array('albumId' => $albumId));
        }
        else
            $this->layout->content = View::make('404');
        //$this->layout->content->albumId = $albumId;
/*
        $this->layout->content->photoName = Input::old('photoName');
        $this->layout->content->shortDescription = Input::old('shDescription');
        $this->layout->content->placeTaken = Input::old('place');
        $this->layout->content->titlePhoto = Input::old('titlePhoto');*/
    }

    public function showSinglePhoto() {
        $this->layout->content = View::make('singlephoto');
    }


}
