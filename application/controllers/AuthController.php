<?php

class AuthController extends Controller
{
    /**
     * Display the register page
     */
    public function registerPage()
    {
        $this->render( 'auth.register' );
    }

    /**
     * Registers a user
     */
    public function register()
    {
        $this->validate( [
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email'      => 'required|email',
            'password'   => 'required|confirmed|min:8'
        ] );
        $user = new UserModel([
            'first_name' => $_REQUEST['first_name'],
            'last_name'  => $_REQUEST['last_name'],
            'email'      => $_REQUEST['email']
        ]);
        // Password is a private field, therefore can't be mass assigned
        $user->password = hash('md5', $_REQUEST['password']);

        if ( $user->save() ) {
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->success('Awesome! you can now login!');

            $this->redirect();

        } else {
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error('Oups! We could not register you...');

            $this->redirectBack();
        }

    }

    /**
     * Display the login page
     */
    public function loginPage()
    {
        $this->render( 'auth.login' );
    }

    /**
     * Log a user in
     */
    public function login()
    {
        $this->validate( [
            'email'      => 'required|email',
            'password'   => 'required|min:8'
        ] );

        echo 'ok';
    }
}