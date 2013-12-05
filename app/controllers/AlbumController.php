<?php
/**
 * Class AlbumController
 */
class AlbumController extends BaseController {

    public function uploadPhoto() {
        $currentAlbumId = Input::get('albumId');

        if(Auth::check()){
            $album = new Album();
            $currentUserID = Auth::user()->id;
            if($album->isUserAlbumCreator($currentUserID, $currentAlbumId) || Auth::user()->role_id == 1){
                $photoName = Input::get('photoName');
                $shortDescription = Input::get('shDescription');
                $placeTaken = Input::get('placeTaken');
                $selectedTags = Input::get('tags');

                $photoFiles = null;
                if (Input::hasFile('photos'))
                    $photoFiles = Input::file('photos');

                $titlePhoto = Input::get('titlePhoto');

                return $album->uploadPhoto($currentAlbumId, $currentUserID, $photoName, $shortDescription, $placeTaken, $selectedTags, $photoFiles, $titlePhoto);
                //return $currentAlbumId.$currentUserID.$photoName.$shortDescription.$placeTaken.$photoFile.$titlePhoto;
                //return Redirect::to('albums/'.$currentAlbumId);
            }
        }
        //return $this->getPhotos($currentAlbumId);
    }

    public function editAlbum() {
        $currentAlbumId = Input::get('albumId');

        if(Auth::check()){
            $album = new Album();
            $currentUserID = Auth::user()->id;
            if($album->isUserAlbumCreator($currentUserID, $currentAlbumId) || Auth::user()->role_id == 1){

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
        }
        //return Redirect::to('albums/'.$currentAlbumId);
    }

    /*
     * Deletes
     */
    public function deletePhoto(){

        if(Auth::check()){
            $currentUserID = Auth::user()->id;
            $photoId = Input::get('photoId');
            $photo = new Photo();
            if($photo->isUserPhotoCreator($currentUserID, $photoId) || Auth::user()->role_id == 1){
               $album = new Album();
               return $album->deletePhoto($photoId);
            }
        }
        return "not singned in or havent rules to delete";
    }

    public function deleteAlbum(){

        if(Auth::check()){
            $currentUserID = Auth::user()->id;
            $albumId = Input::get('albumId');
            $album = new Album();
            if($album->isUserAlbumCreator($currentUserID, $albumId) || Auth::user()->role_id == 1){

                return $album->deleteAlbum($albumId);
            }
        }
        return "u have no rules";
    }

    public function getAlbumPhotos($albumId){
        $album = new Album();
        return $album->getAlbumPhotos($albumId);
    }

    public function getAlbumDataByAlbumId($albumId){
        $album = new Album();
        return $album->getAlbumDataByAlbumId($albumId);
    }

    /*
     * Likes
     */
    public function getAlbumLikes($albumId){
        $album = new Album();
        return $album->getAlbumLikes($albumId);
    }

    public function isLikeAlreadyExists($currentAlbumId){
        $album = new Album();
        if(Auth::check()){
            $currentUserID = Auth::user()->id;
            return $album->isLikeAlreadyExists($currentAlbumId, $currentUserID);
        }
        return "u not signed in";
    }

    public function makeLike(){
        if(Auth::check())
            if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                return $this->makeALike();
    }

    public function makeALike(){
        $album = new Album();
        $currentAlbumId = Input::get('albumId');
        if(Auth::check()){
            $currentUserID = Auth::user()->id;
            return $album->makeLike($currentAlbumId, $currentUserID);
        }
    }

    /*
     * Comments
     */
    public function getAlbumComments($albumId){
        $album = new Album();
        return $album->getAlbumComments($albumId);
    }

    public function writeComment(){
        $album = new Album();

        $currentUserID = null; //defoult
        if(Auth::check())
            $currentUserID = Auth::user()->id;

        $currentAlbumId = Input::get('albumId');
        $comment = Input::get('comment');
        $posterIp = Request::getClientIp();

        return $album->writeComment($comment, $currentAlbumId, $currentUserID, $posterIp);
    }

    /*
     * Views
     */
    public function countViews($albumId){
        $album = new Album();
        return $album->countViews($albumId);
    }

    /*
     * All user albums for user page
     */
    public function getAllUserAlbums($userId){
        $album = new Album;
        return $album->getAllUserAlbums($userId);
    }

    public function isUserAlbumCreator($albumId){
        $album = new Album;
        $currentUserId = 0;
        if(auth::check())
            $currentUserId = Auth::user()->id;
        return $album->isUserAlbumCreator($currentUserId, $albumId);
    }

    public function isUserHavingPrivilegies($albumId){
        $album = new Album;

        if(Auth::check()){
            $userId = Auth::user()->id;
            if($album->isUserAlbumCreator(Auth::user()->id, $albumId) || Auth::user()->role_id == 1)
                return 1;
        }
        return 0;
    }

}