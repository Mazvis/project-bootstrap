<?php

class HomeController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    /**
     * Show home page - the login page.
     */
    public function showWelcome() {
        $this->layout->content = View::make('hello');
        $this->layout->bodyclass = "sign-in-page";
    }

    /**
     * Show the user profile.
     */
    public function showProfile() {
        $this->layout->content = View::make('profile');
    }

    public function showLogin() {
        $this->layout->content = View::make('login');
    }


    Public static function has_file($key) {
        return ! is_null(static::file("{$key}.tmp_name"));
    }

    /**
     * Show main page.
     */
    public function showMain() {
        $this->layout->content = View::make('main');

        // upload photo
        if (Input::hasFile('photo')){
            $file = Input::file('photo');

            $destinationPath = 'uploads/'.str_random(8);

            $filename = $file->getClientOriginalName();
            //$extension =$file->getClientOriginalExtension();
            $upload_success = Input::file('photo')->move($destinationPath, $filename);

            if( $upload_success ) {
                return Response::json('success', 200);
            } else {
                return Response::json('error', 400);
            }

        }

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
        DB::insert('insert into albums (album_name, album_short_description, album_full_description, album_place) values (?, ?, ?, ?)', array($name,$shDesription,$description,$place));


    }

    public function showAlbums() {
        $this->layout->content = View::make('albums');
    }
    public function showSingleAlbum() {
        $this->layout->content = View::make('singlealbum');
    }
    public function showSinglePhoto() {
        $this->layout->content = View::make('singlephoto');
    }


}
