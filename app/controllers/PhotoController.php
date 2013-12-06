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
                $selectedCategories = Input::get('categories');
                $editedTags = Input::get('photoTags');

                $photoName = Input::get('photoName');
                $shortDescription = Input::get('shDescription');
                $placeTaken = Input::get('placeTaken');
                $albumTitlePhoto = Input::get('albumTitlePhoto');

                $photo = new Photo;
                return $photo->editPhoto($currentAlbumId, $currentPhotoId, $currentUserID, $photoName, $shortDescription, $placeTaken, $selectedCategories, $editedTags, $albumTitlePhoto);
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
    public function getAllExistingCategories(){
        $photo = new Photo;
        return $photo->getAllExistingCategories();
    }


    public function getTagsData($photoId){
        $photo = new Photo;
        return $photo->getTagsData($photoId);
    }

    public function getCategoriesData($photoId){
        $photo = new Photo;
        return $photo->getCategoriesData($photoId);
    }

    public function getPhotoTagsRow($photoId){
        $photo = new Photo;
        return $photo->getPhotoTagsRow($photoId);
    }

    public function getPhotoTagNames($photoId){
        $photo = new Photo;
        return $photo->getPhotoTagNames($photoId);
    }

    public function getTagId($tagName){
        $photo = new Photo;
        return $photo->getTagId($tagName);
    }
    public function getTagData($tagName){
        $photo = new Photo;
        return $photo->getTagData($tagName);
    }

    public function getPhotosByTagName($tagName){
        $photo = new Photo;
        return $photo->getPhotosByTagName($tagName);
    }

    public function getPhotosByCatName($catName){
        $photo = new Photo;
        return $photo->getPhotosByCatName($catName);
    }

    public function searchTag(){
        $tagName = Input::get('photo-search-by-tag');
        $photo = new Photo;
        return Redirect::to('search/'.$tagName);
    }


    public function getPhotoDataByTag($tag_id){
        $photo = new Photo;
        return $photo->getPhotoDataByTag($tag_id);
    }

    public function getPhotoDataByTagId($tag_id){
        $photo = new Photo;
        return $photo->getPhotoDataByTagId($tag_id);
    }

    //for admin panel
    public function createTag(){
        $tag = Input::get('tagName');
        $photo = new Photo;
        return $photo->createTag($tag);
    }
    public function createCategory(){
        $tag = Input::get('catName');
        $tagDescription = Input::get('catDescription');
        $photo = new Photo;
        return $photo->createCategory($tag, $tagDescription);
    }

    public function deleteTag(){
        $tag = Input::get('tag');
        $selectedTags = Input::get('tags');
        $photo = new Photo;
        return $photo->deleteTag($tag, $selectedTags);
    }
    public function deleteCategory(){
        $category = Input::get('category');
        $selectedCategories = Input::get('categories');
        $photo = new Photo;
        return $photo->deleteCategory($category, $selectedCategories);
    }



    /*
     * Views
     */
    public function countViews($photoId){
        $photo = new Photo();
        $photo->countViews($photoId);
    }

    public function getRandomPhoto(){
        $photo = new Photo();
        return $photo->getRandomPhoto();
    }

    public function getMostViewedPhoto(){
        $photo = new Photo();
        return $photo->getMostViewedPhoto();
    }

}
