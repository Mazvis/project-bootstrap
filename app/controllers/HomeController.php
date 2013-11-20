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
     * Show home page.
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

    /**
     * Show the login page.
     */
    public function showLogin() {
        $this->layout->content = View::make('login');
    }

    /**
     * Show the all albums page.
     */
    public function showAlbums() {
        $this->layout->content = View::make('albums');
    }

    /**
     * Show the album page.
     */
    public function showSingleAlbum($albumId)
    {
        $album = new AlbumController();
        $albumName = $album->getAlbumNameById($albumId);

        if($albumName){
            $this->layout->content = View::make('singlealbum', array('albumId' => $albumId));
            $this->layout->content->albumId = $albumId;

            $this->layout->content->album_photos_info_array = $album->getPhotos($albumId);
            $this->layout->content->album_info_array = $album->getAlbumTitlePhotoUrlById($albumId);

            $this->layout->content->likes_array = $album->getlikesArray($albumId);
            $this->layout->content->comments_array = $album->getCommentsArray($albumId);
        }
        else
            $this->showNotFoundPage();
    }

    /**
     * Show the photo page.
     */
    public function showSinglePhoto() {
        $this->layout->content = View::make('singlephoto');
    }

    /**
     * Show the 404 page.
     */
    public function showNotFoundPage() {
        $this->layout->content = View::make('404');
    }
// other
    public function showPhotos() {

        $home = new Home;
        return $home->getPhotosJson();
    }

}
