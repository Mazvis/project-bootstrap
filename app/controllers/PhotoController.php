<?php

class PhotoController extends BaseController {

    public function getPhotoDataByPhotoId($photoId, $albumId){
        $photo = new Photo();
        return $photo->getPhotoDataByPhotoId($photoId, $albumId);
    }

    public function getAllPhotoData(){
        $photo = new Photo;
        return $photo->getAllPhotoData();
    }

    public function editPhoto() {

        if(Auth::check()){
            $photo = new Photo();
            $currentUserID = Auth::user()->id;
            $currentPhotoId = Input::get('photoId');
            if($photo->isUserPhotoCreator($currentUserID, $currentPhotoId) || Auth::user()->role_id == 1){

                $currentAlbumId = Input::get('albumId');
                $selectedTags = Input::get('tags');


                $photoName = Input::get('photoName');
                $shortDescription = Input::get('shDescription');
                $placeTaken = Input::get('placeTaken');
                $albumTitlePhoto = Input::get('albumTitlePhoto');

                $photo = new Photo;
                return $photo->editPhoto($currentAlbumId, $currentPhotoId, $currentUserID, $photoName, $shortDescription, $placeTaken, $selectedTags, $albumTitlePhoto);
            }
        }
    }

    public function deletePhoto(){
        $currentAlbumId = Input::get('albumId');

        if(Auth::check()){
            $photo = new Photo();
            $currentUserID = Auth::user()->id;
            $currentPhotoId = Input::get('photoId');
            if($photo->isUserPhotoCreator($currentUserID, $currentPhotoId) || Auth::user()->role_id == 1){
                return $photo->deletePhoto($currentPhotoId);
                //return Redirect::to('albums/'.$currentAlbumId);
            }
        }
        //return $currentAlbumId;
    }

    /*
     * Likes
     */
    public function getPhotoLikes($albumId){
        $photo = new Photo();
        return $photo->getPhotoLikes($albumId);
    }

    public function isLikeAlreadyExists($currentPhotoId){
        $photo = new Photo();
        if(Auth::check()){
            $currentUserID = Auth::user()->id;
            return $photo->isLikeAlreadyExists($currentPhotoId, $currentUserID);
        }
        return "u not signed in";
    }

    public function makeLike(){
        if(Auth::check())
            if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                return $this->makeALike();
    }

    public function makeALike(){
        $photo = new Photo();
        $currentPhotoId = Input::get('photoId');
        if(Auth::check()){
            $currentUserID = Auth::user()->id;
            return $photo->makeLike($currentPhotoId, $currentUserID);
        }
    }

    /*
     * Comments
     */
    public function getPhotoComments($photoId){
        $photo = new Photo();
        return $photo->getPhotoComments($photoId);
    }

    public function writeComment(){
        $photo = new Photo();

        $currentUserID = null;
        if(Auth::check())
            $currentUserID = Auth::user()->id;

        $currentPhotoId = Input::get('photoId');
        $comment = Input::get('comment');
        $posterIp = Request::getClientIp();

        return $photo->writeComment($comment, $currentPhotoId, $currentUserID, $posterIp);
    }

    /*
     * Tags
     */
    public function getAllExistingTags(){
        $photo = new Photo;
        return $photo->getAllExistingTags();
    }

    public function getTagsData($photoId){
        $photo = new Photo;
        return $photo->getTagsData($photoId);
    }

    public function getTagId($tagName){
        $photo = new Photo;
        return $photo->getTagId($tagName);
    }
    public function getTagData($tagName){
        $photo = new Photo;
        return $photo->getTagData($tagName);
    }

    public function getPhotoDataByTag($tag_id){
        $photo = new Photo;
        return $photo->getPhotoDataByTag($tag_id);
    }

    public function getPhotoDataByTagId($tag_id){
        $photo = new Photo;
        return $photo->getPhotoDataByTagId($tag_id);
    }

    /*
     * Views
     */
    public function countViews($photoId){
        $photo = new Photo();
        $photo->countViews($photoId);
    }

}
