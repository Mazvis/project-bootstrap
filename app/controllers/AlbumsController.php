<?php

class AlbumsController extends BaseController {

    public function getData() {
        /*$currentUserId = Auth::user()->id;
        if(!$albumName)
            return "";*/

        $albumName = Input::get('name');
        $shortDescription = Input::get('shDescription');
        $fullDescription = Input::get('description');
        $placeTaken = Input::get('place');

        $albums = new Albums;
        return $albums->createAlbum($albumName, $shortDescription, $fullDescription, $placeTaken);
    }

}
