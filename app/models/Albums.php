<?php

class Albums extends Eloquent{

    public function createAlbum($albumName, $shortDescription, $fullDescription, $placeTaken){
        /*
        $photos = DB::table('photos')->get();
        $i=0;
        $mas = null;
        //$photo = DB::table('photos')->lists('photo_destination_url');
        foreach ($photos as $photo)
        {
            $mas[$i] = $photo->photo_destination_url;
            $i++;
        }
        return $mas;*/
        return $albumName.$shortDescription.$fullDescription.$placeTaken;
    }
}