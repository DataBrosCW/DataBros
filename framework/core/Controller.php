<?php

/**
 * Default controller class
 * All controllers extend this class
 */
abstract class Controller
{

    protected $blade;

    /**
     * Controller constructor
     *
     * Load Blade template engine
     */
    public function __construct()
    {
        $this->blade = new \Jenssegers\Blade\Blade( VIEW_PATH, CACHE_PATH );
    }

    /**
     * Returns a view with parameters
     */
    protected function render( $viewName, $parameters = [] )
    {
        echo $this->blade->render( $viewName, $parameters );
    }

    /**
     * Validates a request
     */
    public function validate($rules = []){
        if ($rules == []) return true;

        // We instanciate a Validator and validate the request
        $validator = new Validator($rules);
        if ($validator->validate()){
            return true;
        } else {
            // If validation fails, we send back to the previous page with errors
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error('Oups! There were some validation errors...');

            foreach ($validator->errors() as $keyError => $errors){
                $message = 'Error(s) with the field ' . $keyError . ':';
                foreach ($errors as $error){
                    $message.= '<br>'.$error;
                }

                $msg->error($message);
            }

            $this->redirectBack();
        }
    }

    /**
     * Redirect to the previous page
     */
    public function redirectBack(){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    /**
     * Redirect to url on app
     */
    public function redirect($path='', $statusCode = 303){
        $url = config('app_url').$path;

        header("Location: ".$url, true, $statusCode );
        exit();
    }


}