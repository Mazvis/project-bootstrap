<?php

class Home extends Eloquent{

    public function getPhotos(){

        // for photos displaying on page
        $photos = DB::table('photos')->get();
        $i=0;
        $mas = null;
        foreach ($photos as $photo)
            $mas[$i++] = $photo->photo_destination_url;

        return $mas;
    }

    public function getPhotosJson(){
        $mas = $this->getPhotos();
        return json_encode($mas);
    }
}