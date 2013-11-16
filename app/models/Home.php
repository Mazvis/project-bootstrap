<?php

class Home extends Eloquent{

    public function getPhotos(){

        // for photos displaying on page
        $photos = DB::table('photos')->get();
        $i=0;
        $mas = null;
        //$photo = DB::table('photos')->lists('photo_destination_url');
        foreach ($photos as $photo)
            $mas[$i++] = $photo->photo_destination_url;
            //$mas[$i] = $photo['0'];

        return $mas;
    }
}