<?php

/**
 * Default controller class
 * All controllers extend this class
 */
abstract class Controller
{

    protected $blade;

//    TODO: implement a simple validation system + request functions such as redirect (add names to routes)

    public function __construct()
    {
        $this->blade = new \Jenssegers\Blade\Blade( VIEW_PATH, CACHE_PATH );
    }

    protected function render( $viewName, $parameters = [] )
    {
        echo $this->blade->render( $viewName, $parameters );
    }


}