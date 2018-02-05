<?php

class AuthController extends Controller
{
    public function registerPage()
    {
        $this->render('auth.register');
    }

    public function register(  )
    {
        $user = new UserModel([
            'first_name' => 'ok'
        ]);
        dd($user);
    }
}