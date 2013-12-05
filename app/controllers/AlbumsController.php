<?php

class AlbumsController extends BaseController {

    public function createAlbum() {

        if(Auth::check()){
            if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
                $currentUserId = Auth::user()->id;
                $albumName = Input::get('name');
                $shortDescription = Input::get('shDescription');
                $fullDescription = Input::get('description');
                $placeTaken = Input::get('place');

                $albums = new Albums;
                return $albums->createAlbum($currentUserId, $albumName, $shortDescription, $fullDescription, $placeTaken);
            }
        }
        return Redirect::back();
    }

    public function getAllAlbums(){
        $albums = new Albums();
        return $albums->getAllAlbums();
    }
}