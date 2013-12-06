<?php

/**
 * Class AlbumsController
 */
class AlbumsController extends BaseController {

    /**
     * Creates album and redirects page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Returs all albums array and show in albums page
     *
     * @return mixed
     */
    public function getAllAlbums(){
        $albums = new Albums();
        return $albums->getAllAlbums();
    }
}