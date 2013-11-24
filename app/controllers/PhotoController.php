<?php

class PhotoController extends BaseController {
    /*
     * gets the current photo data
     */
    public function getPhotoData($photoId){
        $photo = new Photo;
        return $photo->getPhotoData($photoId);
    }

    /*
     * Gets the current photo name
     */
    public function getPhotoNameByAlbumAndPhotoId($albumId, $photoId){
        $photo = new Photo;
        return $photo->getPhotoNameByAlbumAndPhotoId($albumId, $photoId);
    }

    public function editPhoto() {
        $currentPhotoId = Input::get('photoId');
        $currentAlbumId = Input::get('albumId');
        $selectedTags = Input::get('tags');
        if(Auth::check()){
            $currentUserID = Auth::user()->id;

            $photoName = Input::get('photoName');
            $shortDescription = Input::get('shDescription');
            $placeTaken = Input::get('placeTaken');
            $albumTitlePhoto = Input::get('albumTitlePhoto');

            $photo = new Photo;
            $photo->editPhoto($currentAlbumId, $currentPhotoId, $currentUserID, $photoName, $shortDescription, $placeTaken, $selectedTags, $albumTitlePhoto);
        }
        return Redirect::back();
        //return $selectedTags;
        //return Redirect::to('albums/'.$currentAlbumId.'photo/'.$currentPhotoId);
        //return $currentAlbumId.$currentPhotoId.$currentUserID.$photoName.$shortDescription.$placeTaken.$albumTitlePhoto;
    }

    public function deletePhoto(){
        $currentAlbumId = Input::get('albumId');

        if(Auth::check()){
            $currentPhotoId = Input::get('photoId');
            $photo = new Photo();
            $photo->deletePhoto($currentPhotoId);
            return Redirect::to('albums/'.$currentAlbumId);
        }
        //return $currentAlbumId;
    }

    /*
     * Likes
     */
    public function getLikesArray($photoId){
        $photo = new Photo();
        return $photo->getlikesArray($photoId);
    }
    public function getAllLikesCount($photoId){
        $photo = new Photo();
        return $photo->getAllLikesCount($photoId);
    }

    public function makeLike(){
        if(Auth::check())
            return $this->makeALike();
        else
            return $this->makeLikeWithIp();
    }

    public function makeALike(){
        $photo = new Photo();
        $currentPhotoId = Input::get('photoId');
        if(Auth::check()){
            $currentUserID = Auth::user()->id;
            return $photo->makeLike($currentPhotoId, $currentUserID);
        }
    }

    public function makeLikeWithIp(){
        $photo = new Photo();
        $currentPhotoId = Input::get('photoId');
        $likerIp = Request::getClientIp();

        return $photo->makeLikeWithIp($currentPhotoId, $likerIp);
    }
    /*
     * Comments
     */
    public function getCommentsArray($photoId){
        $photo = new Photo();
        return $photo->getCommentsArray($photoId);
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

    public function getPhotoDataByTag($tag_id){
        $photo = new Photo;
        return $photo->getPhotoDataByTag($tag_id);
    }
}
