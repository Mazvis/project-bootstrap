<?php

class LoginController extends BaseController {

    public function authLogin() {
        if (Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')))) {
            return Redirect::intended('/');
        }else{
            return Redirect::to('/')->with('tried_login', Input::get('username'));
        }
    }

    public function logout() {
        $logout = new Login;
        return $logout->logout();
    }

}
