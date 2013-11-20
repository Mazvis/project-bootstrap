<?php

class AlbumController extends BaseController {

    public function getData() {
        //$currentUserID = 1;
        //if(Auth::user()->id)
        $currentAlbumId = Input::get('albumId');

        if(Auth::check()){
            $currentUserID = Auth::user()->id;

            //$currentAlbumId = Input::get('albumId');

            $photoName = Input::get('photoName');
            $shortDescription = Input::get('shDescription');
            $placeTaken = Input::get('placeTaken');

            $photoFile = null;
            if (Input::hasFile('photos'))
                $photoFile = Input::file('photos');

            $titlePhoto = Input::get('titlePhoto');

            $album = new Album;
            $album->uploadPhoto($currentAlbumId, $currentUserID, $photoName, $shortDescription, $placeTaken, $photoFile, $titlePhoto);
            //return $currentAlbumId.$currentUserID.$photoName.$shortDescription.$placeTaken.$photoFile.$titlePhoto;
            //return Redirect::to('albums/'.$currentAlbumId);
        }
        return Redirect::to('albums/'.$currentAlbumId);
        //return $this->getPhotos($currentAlbumId);
    }

    public function editAlbum() {
        $currentAlbumId = Input::get('albumId');

        if(Auth::check()){
            $currentUserID = Auth::user()->id;

            $albumName = Input::get('albumName');
            $shortDescription = Input::get('shDescription');
            $fullDescription = Input::get('fullDescription');
            $placeTaken = Input::get('placeTaken');

            $titlePhotoFile = null;
            if (Input::hasFile('albumTitlePhoto'))
                $titlePhotoFile = Input::file('albumTitlePhoto');

            $album = new Album;
            $album->editAlbum($currentAlbumId, $currentUserID, $albumName, $shortDescription, $fullDescription, $placeTaken, $titlePhotoFile);
        }
        return Redirect::to('albums/'.$currentAlbumId);
    }

    public function getAlbumNameById($albumId){
        $album = new Album;
        return $album->getAlbumNameById($albumId);
    }

    public function getPhotos($albumId){
        $album = new Album();
        return $album->getPhotos($albumId);
    }

    public function getAlbumTitlePhotoUrlById($albumId){
        $album = new Album();
        return $album->getAlbumTitlePhotoUrlById($albumId);
    }
    /*
     * Deletes
     */
    public function deletePhoto(){
        if(Auth::check()){
            $photoId = Input::get('photoId');
            //$albumId = Input::get('albumId');
            $album = new Album();
            return $album->deletePhoto($photoId);
        }
        return "not singned in";
    }

    public function deleteAlbum(){
        if(Auth::check()){
            $albumId = Input::get('albumId');
            $album = new Album();
            return $album->deleteAlbum($albumId);
        }
        return "u have no rules";
    }
    /*
     * Likes
     */
    public function getlikesArray($albumId){
        $album = new Album();
        return $album->getlikesArray($albumId);
    }

    public function makeLike(){
        $album = new Album();
        $currentAlbumId = Input::get('albumId');
        if(Auth::check()){
            $currentUserID = Auth::user()->id;
            return $album->makeLike($currentAlbumId, $currentUserID);
        }
        //return Request::getClientIp(); //getenv("REMOTE_ADDR");
    }
    /*
     * Comments
     */
    public function getCommentsArray($albumId){
        $album = new Album();
        return $album->getCommentsArray($albumId);
    }

    public function writeComment(){
        $album = new Album();

        $currentUserID = 0;
        if(Auth::check())
            $currentUserID = Auth::user()->id;
        $currentAlbumId = Input::get('albumId');
        $posterIp = Request::getClientIp();

        $currentUserID = Auth::user()->id;
        return $album->writeComment($currentAlbumId, $currentUserID, $posterIp);
    }
}