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
 * Display the given variable and die
 */
function dd($var=null){
    if ($var) var_dump($var);
    die();
}