<?php

class Router
{
    // TODO: add name to routes

    /**
     * Contains the list of routes used by the app.
     */
    private $uris = [];

    /**
     * Add a route to the router table
     *
     * @param $uri the route url
     * @param $params action, method...
     */
    public function add($uri, $params = []){
        // Remove inital / if exists
        if (substr($uri,0,1)=='/'){
            $uri = substr($uri,1,strlen($uri)-1);
        }

        // Convert the route to a regular expression: escape forward slashes
        $uri = preg_replace('/\//', '\\/', $uri);
        // Convert variables e.g. {controller}
        $uri = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $uri);
        // Convert variables with custom regular expressions e.g. {id:\d+}
        $uri = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $uri);
        // Add start and end delimiters, and case insensitive flag
        $uri = '/^' . $uri . '$/i';

        $this->uris[$uri] = $params;
    }

    /**
     * Looks for a match in URI and call related method
     */
    public function submit()
    {
        $uri = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '/';
        $uri = $this->removeQueryStringVariables($uri);

        //List through the stored URI's
        foreach ($this->uris as $uriKey => $params)
        {
            // See if there is a match
            if (preg_match($uriKey, $uri,$matches))
            {
                $httpMethod = $_SERVER['REQUEST_METHOD']?$_SERVER['REQUEST_METHOD']:'GET';
                if (!isset($params[$httpMethod])) continue;

                // CSRF Verification
                if ($httpMethod == 'POST' && isset($params[$httpMethod]['csrf']) && $params[$httpMethod]['csrf']){
                    if ( empty( $_POST['csrf_token'] ) ||  !checkToken( $_POST['csrf_token']) ) {
                        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                        $msg->error('Oups! CSRF error occured...');

                        header('Location: ' . $_SERVER['HTTP_REFERER']);
                        exit();
                    }
                }

                // Auth Verification
                if (isset($params[$httpMethod]['auth']) && $params[$httpMethod]['auth']){
                    if ( !auth_check() ) {
                        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                        $msg->error('Oups! You are not authenticated...');

                        header('Location: ' . config('app_url'));
                        exit();
                    }
                }

                // If the page requires user token to be set, then we redirect to a page to set it
                if (auth_check() && !isset($_SESSION['user_code'])  && isset($params[$httpMethod]['ebay-auth']) &&  $params[$httpMethod]['ebay-auth'] ){
                    header('Location: ' . config('app_url').'authorize');
                    exit();
                }

                $controller = preg_split("/@/", $params[$httpMethod]['action'])[0];
                $method = preg_split("/@/", $params[$httpMethod]['action'])[1];

                $controller = new $controller();
                $controller->{ $method }();
                return;
            }
        }

        throw new \Exception('No route matched.', 404);

    }

    /**
     * Remove the query string variables from the URL (if any). As the full
     * query string is used for the route, any variables at the end will need
     * to be removed before the route is matched to the routing table.
     */
    protected function removeQueryStringVariables($url)
    {

        // Remove final / if exists
        if (substr($url,-1)=='/'){
            $url = substr($url,0,strlen($url)-1);
        }

        if ($url != '') {
            $parts = explode('&', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }




}