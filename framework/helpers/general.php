<?php

/**
 * Return a variable from the configuration
 */
function config($name) {
    $config = $GLOBALS['config'];
    $itemPath = explode(".",$name);

    foreach ($itemPath as $path){
        $config = $config[$path];
    }
    return $config;
}

/**
 * CSRF Protection
 */
function generateToken()
{
    $sessionId = session_id();
    return sha1( $sessionId.config('app_key') );
}

/**
 *  Verify that given token was successfully received
 */
function checkToken($token){
    return $token === generateToken();
}

/**
 * Display the csrf hidden field in a form
 */
function csrf_field()
{
    echo '<input type="hidden" name="csrf_token" value="'.generateToken().'"/>';
}
