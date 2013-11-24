<?php

class Photo extends Eloquent{

    public function getPhotoNameByAlbumAndPhotoId($albumId, $photoId){
        $photos = DB::select('select * from photos where photo_id = ? and album_id = ?', array($photoId, $albumId));
        //$photos = DB::table('photos')->where('photo_id', '=', $photoId)->get();
        $name = null;
        foreach ($photos as $photo)
            $name = $photo->photo_name;

        return $name;
    }

    public function getPhotoData($photoId){

        $photos = DB::table('photos')->where('photo_id', $photoId)->get();
        $photoData = null;
        foreach ($photos as $photo){
            $photoData['photo_id'] = $photoId;
            $photoData['photo_name'] = $photo->photo_name;
            $photoData['photo_short_description'] = $photo->photo_short_description;
            $photoData['photo_taken_at'] = $photo->photo_taken_at;
            $photoData['photo_destination_url'] = $photo->photo_destination_url;
            $photoData['photo_thumbnail_destination_url'] = $photo->photo_destination_url;
            $photoData['photo_created_at'] = $photo->photo_created_at;
            $photoData['photo_album_id'] = $photo->album_id;
            $photoData['photo_user_id'] = $photo->user_id;
        }

        $users = DB::table('users')->where('id', $photoData['photo_user_id'])->get();
        $photoData['photo_user_name'] = 'Unknown'; //default
        foreach ($users as $user)
            $photoData['photo_user_name'] = $user->username;

        $albums = DB::table('albums')->where('album_id', $photoData['photo_album_id'])->get();
        foreach ($albums as $album)
            $photoData['photo_album_name'] = $album->album_name;

        return $photoData;
    }

    public function editPhoto($currentAlbumId, $currentPhotoId, $currentUserID, $photoName, $shortDescription, $placeTaken, $selectedTags, $albumTitlePhoto) {
        DB::table('photos')
            ->where('photo_id', $currentPhotoId)
            ->update(array(
                    'photo_name' => $photoName,
                    'photo_short_description' => $shortDescription,
                    'photo_taken_at' => $placeTaken,
                    'user_id' => $currentUserID
                )
            );

        //deletes old tags ant insert new
        DB::table('photo_tags')->where('photo_id', $currentPhotoId)->delete();
        for($i = 0; $i < sizeOf($selectedTags); $i++)
            DB::table('photo_tags')->insert(
                array(
                    'photo_id' => $currentPhotoId,
                    'tag_id' => (int)$selectedTags[$i],
                )
            );



        if($albumTitlePhoto){
            //
            $titlePhotos = DB::select('select * from albums where album_id = ?', array($currentAlbumId));
            foreach ($titlePhotos as $title)
                $titlePhotoId = $title->album_title_photo_id;

            //gets old title url
            /*$titlePhotos = DB::table('albums_title_photos')->where('title_photo_id', $titlePhotoId)->get();
            foreach ($titlePhotos as $title)
                $titlePhotoUrl = $title->title_photo_destination_url;
            //delete this url file(need)*/

            $titlePhotos = DB::table('photos')->where('photo_id', $currentPhotoId)->get();
            foreach ($titlePhotos as $title)
                $newTitlePhotoUrl = $title->photo_destination_url;

            DB::table('albums_title_photos')
                ->where('title_photo_id', $titlePhotoId)
                ->update(array(
                        'title_photo_destination_url' => $newTitlePhotoUrl
                    )
                );

        }

    }

    public function deletePhoto($photoId){
        DB::table('photos')->where('photo_id', $photoId)->delete();
    }

    /*
     * Likes
     */
    public function getLikesArray($photoId){
        $likes = DB::table('likes')->where('photo_id', $photoId)->get();
        $userId = null;
        $i = 0;
        foreach ($likes as $like)
            $userId[$i++] = $like->user_id;

        $j = 0;
        $names = null;
        for($i = 0; $i < sizeOf($userId); $i++){
            $users = DB::table('users')->where('id', $userId[$i])->get();
            foreach ($users as $user)
                $names[$j++] = $user->username;
        }

        return $names;
    }

    public function getAllLikesCount($photoId){
        $likes = DB::table('likes')->where('photo_id', $photoId)->get();
        $count = 0;
        foreach ($likes as $like){
            $count++;
        }

        return $count;
    }

    public function makeLike($currentPhotoId, $currentUserID){
        $likes = DB::select('select * from likes where photo_id = ? and user_id = ?', array($currentPhotoId, $currentUserID));
        $mas = null;
        foreach ($likes as $like)
            $mas = $like->user_id;

        if(!$mas){
            DB::table('likes')->insert(
                array(
                    'photo_id' => $currentPhotoId,
                    'user_id' => $currentUserID,
                )
            );
        }

        return $currentUserID;
    }

    public function makeLikeWithIp($currentPhotoId, $likerIp){
        $likes = DB::select('select * from likes where photo_id = ? and liker_ip = ?', array($currentPhotoId, $likerIp));
        $mas = null;
        foreach ($likes as $like)
            $mas = $like->liker_id;

        if(!$mas){
            DB::table('likes')->insert(
                array(
                    'photo_id' => $currentPhotoId,
                    'liker_ip' => $likerIp,
                )
            );
        }

        return $likerIp;
    }

    /*
     * Comments
     */
    public function getCommentsArray($photoId){
        $comments = DB::table('comments')->where('photo_id', $photoId)->get();

        $mas  = null;
        $i = 0;
        foreach ($comments as $comment){
            $mas[$i]['comment_id'] = $comment->user_id;
            $mas[$i]['comment'] = $comment->comment;
            $mas[$i]['photo_id'] = $comment->photo_id;
            $mas[$i]['created_at'] = $comment->created_at;
            $mas[$i]['user_id'] = $comment->user_id;
            $mas[$i]['commenter_ip'] = $comment->commenter_ip;

            if($mas[$i]['user_id']){
                $users = DB::table('users')->where('id', $mas[$i]['user_id'])->get();
                foreach ($users as $user)
                    $mas[$i]['username'] = $user->username;
            }
            else
                $mas[$i]['username'] = 'Unknown';
            $i++;
        }

        return $mas;
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

    public function getTagsData($photoId){
        /*for ($j = 0; $j < $i; $j++)
    $tagNames = DB::select('select * FROM tags where tag_id = ?', array($tagId[$i]));
    foreach ($tagNames as $tagName){
        $photoData = $tagName->tag_name;
}
        SELECT tags.tag_name FROM photo_tags LEFT JOIN tags ON photo_tags.tag_id = tags.tag_id;*/
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

    public function getTagId($tagName){
        $tags = DB::table('tags')->where('tag_name', $tagName)->get();
        $tagId = null;
        foreach ($tags as $tag)
            $tagId = $tag->tag_id;
        return $tagId;
    }

    public function getPhotoDataByTag($tag_id){
        $tags = DB::table('photo_tags')->where('tag_id', $tag_id)->get();
        $photoId = null;
        $i = 0;
        foreach ($tags as $tag){
            $photoId[$i++] = $tag->photo_id;
        }

        $photoData = null;
        for($i = 0; $i < sizeOf($photoId); $i++){
            $photoData[$i] = $this->getPhotoData($photoId[$i]);
        }
        //var_dump($photoData);
        return $photoData;
    }

}