<?php

class Album extends Eloquent{

    public function uploadPhoto($currentAlbumId, $currentUserID, $photoName, $shortDescription, $placeTaken, $photoFile, $titlePhoto){
        // upload photo
        $filename = "*";
        $extension = "*";
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

        }

        /*
        // for photos displaying on page
        $photos = DB::table('photos')->get();
        $i=0;
        $mas = null;
        //$photo = DB::table('photos')->lists('photo_destination_url');
        foreach ($photos as $photo)
        {
            $mas[$i] = $photo->photo_destination_url;
            //$mas[$i] = $photo['0'];
            $i++;
        }
        $this->layout->content->photos_url = $mas;


        $this->layout->content->name = '*';
        $this->layout->content->shDescription = '*';
        $this->layout->content->description = '*';
        $this->layout->content->place = '*';

        //upload albums in database
        $name = Input::get('name');

        $shDesription = Input::get('shDescription');
        $description = Input::get('description');
        $place = Input::get('place');
        //DB::insert('insert into albums (album_name, album_short_description, album_full_description, album_place) values (?, ?, ?, ?)', array($name,$shDesription,$description,$place));
        */
        return $currentAlbumId.$currentUserID.$photoName.$shortDescription.$placeTaken.$filename.$extension.$titlePhoto;
    }

    public function getAlbumNameById($albumId){
        $albums = DB::table('albums')->where('album_id', '=', $albumId)->get();
        $mas = null;
        foreach ($albums as $album)
            $mas = $album->album_name;

        return $mas;
        /*
        $albums = DB::select('select * from albums where album_name = ?', array($albumName));
        if($albums[0])
            return $albums[0]->album_id;
        else
            return 2;*/
    }
}