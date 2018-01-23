<?php

class Router
{
    /**
     * Contains the list of routes used by the app.
     */
    private $uris = [];

    /**
     * Class-wide items to clean
     */
    private $toTrim = '/\^$';

    public function add($uri, $method){
        $uri = trim($uri, $this->toTrim);
        $this->uris[$uri] = $method;
    }

    /**
     * Looks for a match in URI and call related method
     */
    public function submit()
    {
        $uri = isset($_REQUEST['uri']) ? $_REQUEST['uri'] : '/';
        $uri = trim($uri, $this->toTrim);

        /**
         * List through the stored URI's
         */
        foreach ($this->uris as $uriKey => $action)
        {
            /**
             * See if there is a match
             */
            if (preg_match("#^$uriKey$#", $uri))
            {
                /**
                 * Pass an array for arguments
                 */
                $controller = preg_split("/@/", $action)[0];
                $method = preg_split("/@/", $action)[1];

                $controller = new $controller();
                $controller->{ $method }();
                return;
            }

        }

    }




}