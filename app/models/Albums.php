<?php

class Albums{

    /**
     * @param $currentUserId
     * @param $albumName
     * @param $shortDescription
     * @param $fullDescription
     * @param $placeTaken
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAlbum($currentUserId, $albumName, $shortDescription, $fullDescription, $placeTaken){

        $success = DB::table('albums')->insert(
            array(
                'album_name' => $albumName,
                'album_short_description' => $shortDescription,
                'album_full_description' => $fullDescription,
                'album_place' => $placeTaken,
                'user_id' => $currentUserId,
            )
        );
        if($success)
            return Redirect::back();
    }

    /**
     * @return mixed
     */
    public function getAllAlbums(){
        return DB::select('
        select albums.*, users.username
        from albums
        left join users on albums.user_id = users.id
        order by album_created_at', array());
    }

}