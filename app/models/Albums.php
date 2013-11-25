<?php

class Albums extends Eloquent{

    public function createAlbum($currentUserId, $albumName, $shortDescription, $fullDescription, $placeTaken){

        DB::table('albums')->insert(
            array(
                'album_name' => $albumName,
                'album_short_description' => $shortDescription,
                'album_full_description' => $fullDescription,
                'album_place' => $placeTaken,
                'user_id' => $currentUserId,
            )
        );

        //return $currentUserId.$albumName.$shortDescription.$fullDescription.$placeTaken;
    }

    public function getAlbumsData(){

        $allAlbums = DB::table('albums')->get();
        $i = 0;
        $albumId = null;
        $mas = null;
        foreach ($allAlbums as $album){
            $albumId = $album->album_id;

            $all = DB::table('albums')->where('album_id', $albumId)->get();

            //default
            $mas[$i]['album_title_photo_id'] = null;

            foreach ($all as $all2){
                $mas[$i]['album_id'] = $all2->album_id;
                $mas[$i]['album_name'] = $all2->album_name;
                $mas[$i]['album_short_description'] = $all2->album_short_description;
                $mas[$i]['album_full_description'] = $all2->album_full_description;
                $mas[$i]['album_place'] = $all2->album_place;
                $mas[$i]['album_created_at'] = $all2->album_created_at;
                $mas[$i]['album_title_photo_id'] = $all2->album_title_photo_id;
            }

            $photos = DB::select('select count(*) as sum from photos where album_id = ?', array($albumId));
            foreach ($photos as $photo)
                $mas[$i]['album_photos_count'] = $photo->sum;

            //default
            $mas[$i]['photo_destination_url'] = "uploads/1.jpg"; //no image need to upload

            $photos = DB::table('albums_title_photos')->where('title_photo_id', $mas[$i]['album_title_photo_id'])->get();
            foreach ($photos as $photo)
                $mas[$i]['photo_destination_url'] = $photo->title_photo_destination_url;

            $i++;
        }
        //var_dump($mas);
        return $mas;
    }
}