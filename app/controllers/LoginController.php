<?php

class LoginController extends BaseController {

    public function authLogin() {
        $username = Input::get('username');
        $password = Input::get('password');

        $login = new Login;
        return $login->auth($username, $password);
    }

}
