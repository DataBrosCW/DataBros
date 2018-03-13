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
        $user = new UserModel( [
            'first_name' => $_REQUEST['first_name'],
            'last_name'  => $_REQUEST['last_name'],
            'email'      => $_REQUEST['email']
        ] );
        // Password is a private field, therefore can't be mass assigned
        $user->password = hash( 'md5', $_REQUEST['password'] );

        $userExists = UserModel::instantiate()->where( 'email', $_REQUEST['email'] )->limit( 1 )->get();
        if ( $userExists ) {
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error( 'Oups! Another user already uses this email...' );

            $this->redirectBack();
        }


        if ( $user->save() ) {
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->success( 'Awesome! You will receive a confirmation email soon, but you can already login!' );
            if ( config( 'sendgrid.key' ) != null ) {
                $sendgrid = new SendGrid( config( 'sendgrid.key' ) );
                $email = new SendGrid\Email();

                $html = '<h1>Hello ' . $user->first_name . '!</h1><p>Thank you for joining Databros app!</p>';

                $email->addTo( $user->email )
                      ->setFrom( "admin@dbbros.com" )
                      ->setSubject( "Registration confirmation" )
                      ->setHtml( $html );

                $sendgrid->send( $email );
            }

            $this->redirect();

        } else {
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error( 'Oups! We could not register you...' );

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
            'email'    => 'required|email',
            'password' => 'required|min:8'
        ] );

        $msg = new \Plasticbrain\FlashMessages\FlashMessages();

        // Find user in db
        $user = UserModel::instantiate()->where( 'email', $_REQUEST['email'] )->get();
        if ( ! $user || ! $user instanceof UserModel ) {
            $msg->error( 'These crendentials don\'t match our records.' );

            $this->redirectBack();
        }

        // We make sure password is the same
        if ( hash( 'md5', $_REQUEST['password'] ) != $user->password ) {
            $msg->error( 'These crendentials don\'t match our records.' );

            $this->redirectBack();
        }

        $_SESSION['user_id'] = $user->id;
        $msg->success( 'Welcome ' . $user->first_name . '!' );
        $this->redirect();
    }

    /**
     * Logs a user out
     */
    public function logout()
    {
        session_destroy();
        $this->redirect();
    }
}