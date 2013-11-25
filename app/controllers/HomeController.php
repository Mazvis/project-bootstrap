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
    //Show photos in home page
    public function showPhotos() {
        $home = new Home;
        return $home->getPhotosJson();
    }

    /**
     * Show the user profile page.
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
        $albums = new AlbumsController();
        $this->layout->content->album_photos_info_array = $albums->getAlbumsData();
    }

    /**
     * Show the album page.
     */
    public function showSingleAlbum($albumId)
    {
        $photo = new PhotoController();
        $album = new AlbumController();
        $albumName = $album->getAlbumNameById($albumId);

        if($albumName){
            $this->layout->content = View::make('singlealbum', array('albumId' => $albumId));

            $this->layout->content->viewsCount = $album->countViews($albumId);
            $this->layout->content->albumId = $albumId;

            $this->layout->content->album_photos_info_array = $album->getPhotos($albumId);
            $this->layout->content->album_info_array = $album->getAlbumTitlePhotoUrlById($albumId);

            $this->layout->content->all_likes_count = $album->getAllLikesCount($albumId);
            $this->layout->content->likes_array = $album->getlikesArray($albumId);
            $this->layout->content->comments_array = $album->getCommentsArray($albumId);

            $this->layout->content->allExistingTags = $photo->getAllExistingTags();
        }
        else
            $this->showNotFoundPage();
    }

    /**
     * Show the photo page.
     */
    public function showSinglePhoto($albumId, $photoId) {

        //$album = new AlbumController();
        //$albumName = $album->getAlbumNameById($albumId);

        $photo = new PhotoController();
        $photoName = $photo->getPhotoNameByAlbumAndPhotoId($albumId,$photoId);
        if($photoName){
            $this->layout->content = View::make('singlephoto', array('albumId' => $albumId, 'photoId' => $photoId));

            $this->layout->content->viewsCount = $photo->countViews($photoId);
            $this->layout->content->photo_data_array = $photo->getPhotoData($photoId);

            $this->layout->content->all_likes_count = $photo->getAllLikesCount($photoId);
            $this->layout->content->likes_data = $photo->getLikesArray($photoId);
            $this->layout->content->comments_array = $photo->getCommentsArray($photoId);

            $this->layout->content->allExistingTags = $photo->getAllExistingTags();
            $this->layout->content->tags = $photo->getTagsData($photoId);
        }
        else
            $this->showNotFoundPage();
    }

    /*
     * Show tag page
     */
    public function showTagPage($tagName) {
        $photo = new PhotoController();
        $tagId = $photo->getTagId($tagName);
        //if this tag exists:
        if($tagId){
            $this->layout->content = View::make('tag', array('tagName' => $tagName));
            $this->layout->content->tagId = $tagId;
            $this->layout->content->photo_data_array = $photo->getPhotoDataByTag($tagId);
        }
        else
            $this->showNotFoundPage();
    }

    /**
     * Show the 404 page.
     */
    public function showNotFoundPage() {
        $this->layout->content = View::make('404');
    }

}
