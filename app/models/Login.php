<?php

class Login extends Eloquent{

    public function auth($username, $password){
        // get POST data
        $userdata = array(
            'username'      => $username,
            'password'      => $password
        );

        if ( Auth::attempt($userdata) )
        {
            // logged in, go to home
            return Redirect::to('/');
        }
        else
        {
            // auth failure, go back to the login
            return Redirect::to('login')->with('login_errors', true);
        }
    }
}