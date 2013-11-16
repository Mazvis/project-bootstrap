<?php

class AlbumController extends BaseController {

    public $albumID = 0;

    public function getData() {
        $currentUserID = 1;
        if(Auth::user()->id)
            $currentUserID = Auth::user()->id;
        $currentAlbumId = Input::get('albumId'); //temporary

        $photoName = Input::get('photoName');
        $shortDescription = Input::get('shDescription');
        $placeTaken = Input::get('placeTaken');
        $photoFile = null;
        if (Input::hasFile('photo'))
            $photoFile = Input::file('photo');
        $titlePhoto = Input::get('titlePhoto');

        $album = new Album;
        return $album->uploadPhoto($currentAlbumId, $currentUserID, $photoName, $shortDescription, $placeTaken, $photoFile, $titlePhoto);
    }

    public function setAlbumID($albumId){
        $this->albumID = $albumId;
    }

    public function getAlbumNameById($albumId){
        $album = new Album;
        return $album->getAlbumNameById($albumId);
    }
}
