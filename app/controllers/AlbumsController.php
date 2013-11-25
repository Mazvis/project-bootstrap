<?php

class AlbumsController extends BaseController {

    public function getData() {

        if(Auth::user()){
            $currentUserId = Auth::user()->id;


            $albumName = Input::get('name');
            $shortDescription = Input::get('shDescription');
            $fullDescription = Input::get('description');
            $placeTaken = Input::get('place');

            $albums = new Albums;
            $albums->createAlbum($currentUserId, $albumName, $shortDescription, $fullDescription, $placeTaken);
        }
        return Redirect::back();
    }

    public function getAlbumsData(){
        $albums = new Albums();
        return $albums->getAlbumsData();
    }


}
