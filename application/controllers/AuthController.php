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
            $emailSent = true;

            if ( config( 'sendgrid.key' ) != null ) {
                $sendgrid = new SendGrid( config( 'sendgrid.key' ) );
                $email = new SendGrid\Email();

                $html = '<h1>Hello ' . $user->first_name . '!</h1>
<p>Congratulations on registering your DataBros account. We are thrilled to have you.</p>
<p>Ready to have the best shopping experience using our platform? It’s easy!<br>
Just make sure you let us access your eBay account. Here’s how it is done:</p>
<p>1. Click on one of our header buttons: ‘Feed’, ‘Followed products’ or ‘Categories’.</p>
<p>2. A page asking your confirmation in accessing your eBay account will appear. Go to the link provided in the message.</p>
<p>3. Log into eBay using your eBay credentials. You should be redirected to DataBros. All features are now unlocked.</p>
<p>Enjoy.</p>
<p>The DataBros Team</p>';

                $email->addTo( $user->email )
                      ->setFrom( "admin@dbbros.com" )
                      ->setSubject( "Registration confirmation" )
                      ->setHtml( $html );

                try {
                    $sendgrid->send( $email );
                } catch ( Exception $e ) {
                    $emailSent = false;
                }
            }

            if ( $emailSent ) {
                $msg->success( 'Awesome! You will receive a confirmation email soon, but you can already use the app!' );
            } else {
                $msg->success( 'Awesome! You can start using the app right now!' );
            }
            $this->logUserIn($user);
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

        $this->logUserIn($user);
        $msg->success( 'Welcome ' . $user->first_name . '!' );
        $this->redirect();
    }

    private function logUserIn($user){
        $_SESSION['user_id'] = $user->id;
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