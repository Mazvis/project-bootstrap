<?php

class Album extends Eloquent{

    public function uploadPhoto($currentAlbumId, $currentUserID, $photoName, $shortDescription, $placeTaken, $photoFile, $titlePhoto){

        // upload photo to server
        $filename = "";
        if ($photoFile != null){
            $file = $photoFile;

            $destinationPath = 'uploads/'.$currentUserID.'/albums/'.$currentAlbumId;

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $upload_success = $photoFile->move($destinationPath, $filename);
            /*if( $upload_success ) {
                return Response::json('success', 200);
            } else {
                return Response::json('error', 400);
            }*/

            //make: if this albumId exist in albums table do this insert
            //upload photo in database
            DB::table('photos')->insert(
                array('photo_name' => $photoName,
                    'photo_short_description' => $shortDescription,
                    'photo_taken_at' => $placeTaken,
                    'photo_destination_url' => $destinationPath."/".$filename,
                    'photo_thumbnail_destination_url' => null,
                    'album_id' => $currentAlbumId,
                    'user_id' => $currentUserID,
                )
            );

            $sth = DB::table('albums')->where('album_id', $currentAlbumId)->get();
            $oldTitleId = null;
            foreach ($sth as $album)
                $oldTitleId = $album->album_title_photo_id;
            DB::table('albums_title_photos')->where('title_photo_id', $oldTitleId)->delete();

            $insertedPhotoId = DB::table('albums_title_photos')->insertGetId(
                array(
                    'title_photo_destination_url' => $destinationPath."/".$filename,
                    'title_photo_thumbnail_destination_url' => null,
                    'album_id' => $currentAlbumId,
                    'user_id' => $currentUserID,
                )
            );

            /*$insertedPhotoId = DB::insert('insert into photos (photo_name, photo_short_description, photo_taken_at, photo_destination_url,
             photo_thumbnail_destination_url, album_id, user_id)
             values (?, ?, ?, ?, ?, ?, ?)',
             array($photoName, $shortDescription, $placeTaken, $destinationPath."/".$filename, null, $currentAlbumId, $currentUserID));*/

            //if title photo = true then find in albums where is this album and write there the photo path or id(mabe better id)
            if ($titlePhoto == true)
                DB::table('albums')
                    ->where('album_id', $currentAlbumId)
                    ->update(array('album_title_photo_id' => $insertedPhotoId));

        }
        //return $currentAlbumId.$currentUserID.$photoName.$shortDescription.$placeTaken.$filename.$extension.$titlePhoto;
    }

    public function editAlbum($currentAlbumId, $currentUserID, $albumName, $shortDescription, $fullDescription, $placeTaken, $titlePhotoFile){

        $filename = "";
        if ($titlePhotoFile != null){
            $file = $titlePhotoFile;

            $destinationPath = 'uploads/'.$currentUserID.'/albums/'.$currentAlbumId.'/title_photo';

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $titlePhotoFile->move($destinationPath, $filename);
        }

        $sth = DB::table('albums')->where('album_id', $currentAlbumId)->get();
        $oldTitleId = null;
        foreach ($sth as $album)
            $oldTitleId = $album->album_title_photo_id;
        DB::table('albums_title_photos')->where('title_photo_id', $oldTitleId)->delete();

        $insertedPhotoId = DB::table('albums_title_photos')->insertGetId(
            array(
                'title_photo_destination_url' => $destinationPath."/".$filename,
                'title_photo_thumbnail_destination_url' => null,
                'album_id' => $currentAlbumId,
                'user_id' => $currentUserID,
            )
        );

        DB::table('albums')
            ->where('album_id', $currentAlbumId)
            ->update(array(
                'album_name' => $albumName,
                'album_short_description' => $shortDescription,
                'album_full_description' => $fullDescription,
                'album_place' => $placeTaken,
                'album_title_photo_id' => $insertedPhotoId
            )
        );

    }

    public function getAlbumNameById($albumId){
        $albums = DB::table('albums')->where('album_id', '=', $albumId)->get();
        $mas = null;
        foreach ($albums as $album)
            $mas = $album->album_name;

        return $mas;
    }

    public function getPhotos($albumId){

        // for photos displaying on page

        $all = DB::table('photos')->where('album_id', '=', $albumId)->get();
        $i = 0;
        $mas = null;
        foreach ($all as $all2){
            $mas[$i]['photo_id'] = $all2->photo_id;
            $mas[$i]['photo_name'] = $all2->photo_name;
            $mas[$i]['photo_short_description'] = $all2->photo_short_description;
            $mas[$i]['photo_taken_at'] = $all2->photo_taken_at;
            $mas[$i]['photo_destination_url'] = $all2->photo_destination_url;
            $i++;
        }


        /*$photos = DB::table('photos')->where('album_id', '=', $albumId)->get();
        $i=0;
        $mas = null;
        foreach ($photos as $photo)
            $mas[$i++] = $photo->photo_destination_url;*/

        return $mas;
    }

    public function getAlbumTitlePhotoUrlById($albumId){

        // for album info displaying on page

        $all = DB::table('albums')->where('album_id', '=', $albumId)->get();
        $mas = null;
        $mas['album_title_photo_id'] = null;

        foreach ($all as $all2){
            $mas['album_id'] = $all2->album_id;
            $mas['album_name'] = $all2->album_name;
            $mas['album_short_description'] = $all2->album_short_description;
            $mas['album_full_description'] = $all2->album_full_description;
            $mas['album_place'] = $all2->album_place;
            $mas['album_created_at'] = $all2->album_created_at;
            $mas['album_title_photo_id'] = $all2->album_title_photo_id;
        }

        //default
        $mas['photo_destination_url'] = "uploads/1.jpg"; //no image need to upload

        //$photos = DB::table('photos')->where('photo_id', $mas['album_title_photo_id'])->get();
        $photos = DB::table('albums_title_photos')->where('title_photo_id', $mas['album_title_photo_id'])->get();
        foreach ($photos as $photo)
            $mas['photo_destination_url'] = $photo->title_photo_destination_url;

        return $mas;
    }

    public function deletePhoto($photoId){
        DB::table('photos')->where('photo_id', $photoId)->delete();
        DB::table('albums')->where('album_title_photo_id', $photoId)->update(array('album_title_photo_id' => null));
        return "Deleted";
    }

    public function deleteAlbum($albumId){
        DB::table('photos')->where('album_id', $albumId)->delete();
        DB::table('albums')->where('album_id', $albumId)->delete();
        return "Deleted";
    }

    /*
     * Likes
     */
    public function getlikesArray($albumId){
        $likes = DB::table('likes')->where('album_id', $albumId)->get();
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

    public function makeLike($albumId, $currentUserID){
        //$likes = DB::table('likes')->where('album_id', $albumId)->where('user_id', $currentUserID)->get();
        $likes = DB::select('select * from likes where album_id = ? and user_id = ?', array($albumId, $currentUserID));
        $mas = null;
        foreach ($likes as $like)
            $mas = $like->user_id;

        if(!$mas){
            DB::table('likes')->insert(
                array(
                    'album_id' => $albumId,
                    'user_id' => $currentUserID,
                )
            );
        }

        return $currentUserID;
    }

    /*
     * Comments
     */
    public function getCommentsArray($albumId){
        $comments = DB::table('comments')->where('album_id', $albumId)->get();

        $mas  = null;
        $i = 0;
        foreach ($comments as $comment){
            $mas[$i]['comment_id'] = $comment->user_id;
            $mas[$i]['comment'] = $comment->comment;
            $mas[$i]['album_id'] = $comment->album_id;
            $mas[$i]['created_at'] = $comment->created_at;
            $mas[$i]['user_id'] = $comment->user_id;
            $mas[$i]['commenter_ip'] = $comment->commenter_ip;

            $users = DB::table('users')->where('id', $mas[$i]['user_id'])->get();
            foreach ($users as $user)
                $mas[$i]['username'] = $user->username;
            $i++;
        }

        return $mas;
    }

    public function writeComment($currentAlbumId, $currentUserID, $posterIp){
        DB::table('likes')->insert(
            array(
                'album_id' => $albumId,
                'user_id' => $currentUserID,
            )
        );
        return $currentUserID;
    }
}