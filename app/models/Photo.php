<?php

class Photo{

    public function getPhotoDataByPhotoId($photoId, $albumId){
        $photos = DB::select('SELECT photos.* , users.username, albums.album_name
        FROM photos
        LEFT JOIN users ON photos.user_id = users.id
        LEFT JOIN albums ON photos.album_id = albums.album_id
        WHERE photos.photo_id = ? AND albums.album_id = ?
        GROUP BY photos.photo_id', array($photoId, $albumId));

        return $photos;
    }

    //***//
    public function editPhoto($currentAlbumId, $currentPhotoId, $currentUserID, $photoName, $shortDescription, $placeTaken, $selectedCategories, $editedTags, $albumTitlePhoto) {
        //-----------------Editing photo data---------------------//
        //update photo data
        DB::table('photos')
            ->where('photo_id', $currentPhotoId)
            ->update(array(
                    'photo_name' => $photoName,
                    'photo_short_description' => $shortDescription,
                    'photo_taken_at' => $placeTaken
                )
            );

        //deletes old tags and insert new
        //DB::table('photo_tags')->where('photo_id', $currentPhotoId)->delete(); //temporary
        /*for($i = 0; $i < sizeOf($selectedTags); $i++)
            DB::table('photo_tags')->insert(
                array(
                    'photo_id' => $currentPhotoId,
                    'tag_id' => (int)$selectedTags[$i],
                )
            );*/
        //categories

        //DB::table('photo_categories')->where('photo_id', $currentPhotoId)->delete(); //temporary

        for($i = 0; $i < sizeOf($selectedCategories); $i++){
            $catId = DB::select('select * from categories where category_name = ?', array($selectedCategories[$i]));
            if($catId){
                $isExist = DB::select('select * from photo_categories where photo_id = ?', array($currentPhotoId));
                if($isExist)
                    DB::update('update photo_categories set category_id = ? where photo_id = ?', array($catId[0]->category_id, $currentPhotoId));
                else
                    DB::table('photo_categories')->insert(
                        array(
                            'photo_id' => $currentPhotoId,
                            'category_id' => $catId[0]->category_id,
                        )
                    );
            }
        }


        //my new structure
        $explodedTags = null;
        $explodedTags = preg_replace("/[^\w\ _]+/", '', $editedTags); // strip all punctuation characters, news lines, etc.
        $explodedTags = preg_split("/\s+/", $explodedTags); // split by left over spaces
        $tagLine = "";
        for($i=0; $i<sizeOf($explodedTags); $i++)
            $tagLine = $tagLine.$explodedTags[$i].", ";
        $tagLine = substr($tagLine, 0, -2);

        $isExist = DB::select('select * from photo_tags where photo_id = ?', array($currentPhotoId));
        if($isExist)
            DB::update('update photo_tags set tags = ? where photo_id = ?', array($tagLine, $currentPhotoId));
        else
            DB::insert('insert into photo_tags (photo_id, tags) values (?,?)', array($currentPhotoId, $tagLine));



        //-----------------Editing album title photo data---------------------//
        if($albumTitlePhoto){

            //gets old title url
            $titlePhoto = DB::table('albums')->where('album_id', $currentAlbumId)->get();

            //if album exist
            if($titlePhoto != null){

                //deletes old title photo if exists from directory
                $oldAlbumTitlePhoto = null;
                $oldAlbumTitlePhoto = $titlePhoto[0]->album_title_photo_url;
                if($oldAlbumTitlePhoto != null ){
                    if(is_file($oldAlbumTitlePhoto))
                        File::delete($oldAlbumTitlePhoto);
                }
                //deletes old title photo thumb if exists from directory
                $oldAlbumTitlePhotoThumb = null;
                $oldAlbumTitlePhotoThumb = $titlePhoto[0]->album_title_photo_thumb_url;
                if($oldAlbumTitlePhotoThumb != null )
                    if(is_file($oldAlbumTitlePhotoThumb))
                        File::delete($oldAlbumTitlePhotoThumb);
            }

            $titleDestinationPath = 'uploads/albums/'.$currentAlbumId;

            //creates album directory if not exist
            if(!is_dir('uploads'))
                mkdir('uploads', 0777, true);
            if(!is_dir('uploads/albums'))
                mkdir('uploads/albums', 0777, true);
            if(!is_dir('uploads/albums/'.$currentAlbumId))
                mkdir('uploads/albums/'.$currentAlbumId, 0777, true);

            //gets current photo url
            $newTitlePhoto = DB::table('photos')->where('photo_id', $currentPhotoId)->get();
            if($newTitlePhoto){

                $photo = null;
                $photo = $newTitlePhoto[0]->photo_destination_url;
                if($photo != null ){
                    if(is_file($photo)){
                        $photoExtension = File::extension($photo);
                        $newPhoto = $titleDestinationPath."/title_".$currentAlbumId.".".$photoExtension;
                        File::copy($photo, $newPhoto);
                        $photo = $newPhoto;
                    }
                }
                $photoThumb = null;
                $photoThumb = $newTitlePhoto[0]->photo_thumbnail_destination_url;
                if($photoThumb != null){
                    if(is_file($photoThumb)){
                        $thumbExtension = File::extension($photoThumb);
                        $newPhotoThumbUrl = $titleDestinationPath."/title_".$currentAlbumId."_thumb.".$thumbExtension;
                        File::copy($photoThumb, $newPhotoThumbUrl);
                        $photoThumb = $newPhotoThumbUrl;
                    }
                }
                else if($photoThumb == null && is_file($photo) != null){
                    App::make('phpthumb')
                        ->create('resize', array($photo, 200, 200, 'adaptive'))
                        ->save($titleDestinationPath."/", "title_".$currentAlbumId."_thumb.".$photoExtension);
                    $photoThumb = $titleDestinationPath."/title_".$currentAlbumId."_thumb.".$photoExtension;
                }


                DB::table('albums')
                    ->where('album_id', $currentAlbumId)
                    ->update(array(
                        'album_title_photo_url' => $photo,
                        'album_title_photo_thumb_url' => $photoThumb
                    ));
            }
            return 'Edited';

        }
        /*
        if($albumTitlePhoto){

            //gets old title url
            $titlePhoto = DB::table('albums_title_photos')->where('album_id', $currentAlbumId)->get();
            //deletes old title photo from directory
            if($titlePhoto)
                File::delete($titlePhoto[0]->title_photo_destination_url);


            $titlePhotos = DB::table('photos')->where('photo_id', $currentPhotoId)->get();
            if($titlePhotos)
                $newTitlePhotoUrl = $titlePhotos[0]->photo_destination_url;

            $extension = File::extension($newTitlePhotoUrl);
            $size = File::size($newTitlePhotoUrl);

            //uploads new title photo
            $titleDestinationPath = 'uploads/'.$albumCreatorId.'/albums/'.$currentAlbumId.'/title_photo';
            File::copy($newTitlePhotoUrl, $titleDestinationPath."/".$currentAlbumId.".".$extension);

            DB::table('albums_title_photos')->where('album_id',$titlePhoto[0]->album_id)->delete();

            $insertedTitlePhotoId = DB::table('albums_title_photos')->insertGetId(
                array(
                    'title_photo_destination_url' => $titleDestinationPath."/".$currentAlbumId.".".$extension,
                    'title_photo_thumbnail_destination_url' => null,
                    'album_id' => $currentAlbumId,
                    'user_id' => $albumCreatorId,
                    'photo_size' => $size
                )
            );
            DB::table('albums')
                ->where('album_id', $currentAlbumId)
                ->update(array('album_title_photo_id' => $insertedTitlePhotoId));


            /*DB::table('albums_title_photos')
                ->where('title_photo_id', $titlePhotoId)
                ->update(array(
                        'title_photo_destination_url' => $titleDestinationPath."/".$currentAlbumId.".".$extension,
                        'photo_size' => $size
                    )
                );

        }*/
    }

    //***//
    public function deletePhoto($photoId){
        $success = null;
        //deletes all photo likes
        $success[0] = DB::delete('delete from likes where photo_id = ?', array($photoId));

        //deletes all photo comments
        $success[1] = DB::delete('delete from comments where photo_id = ?', array($photoId));

        //deletes photo from directory
        $photo = DB::select('select photo_destination_url from photos where photo_id = ?', array($photoId));
        if($photo)
            if($photo[0]->photo_destination_url)
                $success[2] = File::delete($photo[0]->photo_destination_url);

        //deletes photo tags
        $success[3] = DB::table('photo_tags')->where('photo_id', $photoId)->delete();

        //deletes photo information from database
        $success[4] = DB::table('photos')->where('photo_id', $photoId)->delete();

        foreach($success as $s)
            $s *= $s;

        return $s;
    }

    /*
     * Likes
     */
    public function getPhotoLikes($photoId){
        return DB::select('SELECT likes.*, users.username
        FROM likes
        LEFT JOIN users ON likes.user_id = users.id
        WHERE photo_id = ?', array($photoId));
    }

    public function isLikeAlreadyExists($photoId, $currentUserID){
        $likes = DB::select('select * from likes where photo_id = ? and user_id = ?', array($photoId, $currentUserID));
        if($likes)
            return 1;
        return 0;
    }

    public function makeLike($photoId, $currentUserID){
        $isExist = $this->isLikeAlreadyExists($photoId, $currentUserID);
        if($isExist == 0 && $currentUserID != null){
            DB::table('likes')->insert(
                array(
                    'photo_id' => $photoId,
                    'user_id' => $currentUserID,
                )
            );
        }
        else if($isExist == 1)
            DB::delete('delete from likes where photo_id = ? and user_id = ?', array($photoId, $currentUserID));

        return $currentUserID;
    }

    /*
     * Comments
     */
    public function getPhotoComments($photoId){
        return DB::select('SELECT comments.*, users.username
        FROM comments
        LEFT JOIN users ON comments.user_id = users.id
        WHERE photo_id = ?', array($photoId));
    }

    public function writeComment($comment, $currentPhotoId, $currentUserID, $posterIp){

        DB::table('comments')->insert(
            array(
                'comment' => $comment,
                'photo_id' => $currentPhotoId,
                'user_id' => $currentUserID,
                'commenter_ip' => $posterIp,
            )
        );

        return $comment;
    }

    /*
     * Tags
     */
    public function getAllExistingTags(){
        $tags = DB::table('tags')->get();

        $array = null;
        foreach ($tags as $tag)
            $array[$tag->tag_id] = $tag->tag_name;

        return $array;
    }
    public function getAllExistingCategories(){
        $categories = DB::table('categories')->get();
        $array = null;
        foreach ($categories as $category)
            $array[$category->category_name] = $category->category_name;
        return $array;
    }

    public function getExistingTags(){
        return $tags = DB::table('tags')->get();
    }

    public function getTagsData($photoId){
        $tagsIds = DB::select('select * FROM photo_tags where photo_id = ?', array($photoId));
        $i = 0;
        $tagId = null;
        foreach ($tagsIds as $tag){
            $tagId[$i++] = $tag->tag_id;
        }

        $j = 0;
        $photoData = null;
        for($i = 0; $i < sizeOf($tagId); $i++){
            $tagNames = DB::table('tags')->where('tag_id', $tagId[$i])->get();
            foreach ($tagNames as $tagName)
                $photoData[$j++] = $tagName->tag_name;
        }

        return $photoData;
    }

    public function getCategoriesData($photoId){
        $tagsIds = DB::select('select * FROM photo_categories where photo_id = ?', array($photoId));
        $i = 0;
        $tagId = null;
        foreach ($tagsIds as $tag){
            $tagId[$i++] = $tag->category_id;
        }

        $j = 0;
        $photoData = null;
        for($i = 0; $i < sizeOf($tagId); $i++){
            $tagNames = DB::table('categories')->where('category_id', $tagId[$i])->get();
            foreach ($tagNames as $tagName)
                $photoData[$j++] = $tagName->category_name;
        }

        return $photoData;
    }

    public function getPhotoTagsRow($photoId){
        $tags = DB::select('select * FROM photo_tags where photo_id = ?', array($photoId));
        /*if($tags)
            $tags = $tags[0]->tags;*/
        $tagString = "";
        foreach($tags as $tag)
            $tagString = $tagString.$tag->tags;
        return $tagString;
    }

    public function getPhotoTagNames($photoId){
        $tags = DB::select('select * FROM photo_tags where photo_id = ?', array($photoId));
        $explodedTags = null;
        foreach($tags as $tag){
            $tagStr = $tag->tags;
            $explodedTags = preg_replace("/[^\w\ _]+/", '', $tag->tags); // strip all punctuation characters, news lines, etc.
            $explodedTags = preg_split("/\s+/", $explodedTags); // split by left over spaces
        }
        return $explodedTags;
    }
    //older
    public function getTagData($tagName){
        return DB::table('tags')->where('tag_name', $tagName)->get();
    }
    //newest
    public function getPhotosByTagName($tagName){
        return DB::select("SELECT photos.*, albums.album_name
        FROM photos
        Left join photo_tags on photo_tags.photo_id = photos.photo_id
        left join albums on albums.album_id = photos.album_id
        WHERE photo_tags.tags LIKE ?", array('%'.$tagName.'%'));
    }
    public function getPhotosByCatName($catName){
        return DB::select("SELECT photos.*, albums.album_name, categories.*
        FROM photos
        Left join photo_categories on photo_categories.photo_id = photos.photo_id
        left join albums on albums.album_id = photos.album_id
        left join categories on categories.category_id = photo_categories.category_id
        WHERE categories.category_name = ?", array($catName));
    }

    //for admin panel
    public function createTag($tag){
        $istag = DB::table('tags')->where('tag_name', $tag)->get();
        //if tag is not already exist
        if(!$istag)
            DB::table('tags')->insert(array('tag_name' => $tag));
        return Redirect::back();
    }
    public function createCategory($tag, $tagDescription){
        $istag = DB::table('categories')->where('category_name', $tag)->get();
        //if tag is not already exist
        if(!$istag)
            DB::table('categories')->insert(array('category_name' => $tag, 'category_description' => $tagDescription));
        return Redirect::back();
    }

    public function deleteTag($tag, $selectedTags){

        if($tag){
            $tagId = null;

            $tagId = DB::table('tags')->where('tag_name', $tag)->get();
            if($tagId){
                $tagId = $tagId[0]->tag_id;

        DB::table('photo_tags')->where('tag_id', $tagId)->delete();}
        DB::table('tags')->where('tag_name', $tag)->delete();
        }

        for($i = 0; $i < sizeOf($selectedTags); $i++){
            DB::table('tags')->where('tag_id', $selectedTags[$i])->delete();
            DB::table('photo_tags')->where('tag_id', $selectedTags[$i])->delete();
        }
        return Redirect::back();
    }
    public function deleteCategory($categoryName, $selectedCategories){

        if($categoryName){
            $tagId = null;

            $tagId = DB::table('categories')->where('category_name', $categoryName)->get();
            if($tagId){
                $tagId = $tagId[0]->category_id;

                DB::table('photo_categories')->where('category_id', $tagId)->delete();
            }
            DB::table('categories')->where('category_name', $categoryName)->delete();
        }

        for($i = 0; $i < sizeOf($selectedCategories); $i++){
            $catId = DB::table('categories')->where('category_name', $categoryName)->get();
            if($catId){
                $catId = $catId[0]->category_id;
                DB::table('photo_categories')->where('category_id', $catId)->delete();
            }
            DB::table('categories')->where('category_name', $selectedCategories[$i])->delete();
        }
        return Redirect::back();
    }

    /*
     * Views
     */
    public function countViews($photoId){
        DB::update('update photos set views = views+1 where photo_id = ?', array($photoId));
    }

    public function isUserPhotoCreator($currentUserId, $photoId){
        $albums = DB::table('photos')->where('photo_id', $photoId)->get();
        $userId = null;
        foreach($albums as $album)
            $userId = $album->user_id;
        if($currentUserId == $userId)
            return 1;
        return 0;
    }
//**********************************//
    public function getAllPhotoData(){
        $photos = DB::select('select photos.*, albums.album_name as album_name from photos left join albums on photos.album_id = albums.album_id order by photos.photo_created_at', array());
        return $photos;
    }

    public function getPhotoDataByTagId($tag_id){
        return DB::select('
            select photos.*, albums.album_name
            from photos
            left join photo_tags on photo_tags.photo_id = photos.photo_id
            left join albums on albums.album_id = photos.album_id
            where photo_tags.tag_id = ?
            group by photos.photo_id',
                array($tag_id));
    }

    /**
     * Gets random photo from database
     * @return mixed
     */
    public function getRandomPhoto(){
        return $randPhoto = DB::select('SELECT * FROM photos ORDER BY RAND() LIMIT 0,1');

        /*return $randPhoto = DB::select('SELECT * FROM photos
         WHERE photo_id >= (SELECT FLOOR( MAX(photo_id) * RAND()) FROM photos )
         ORDER BY photo_id LIMIT 1');*/
    }

    public function getMostViewedPhoto(){
        return $randPhoto = DB::select('SELECT * FROM photos order by views desc limit 1');
    }


}