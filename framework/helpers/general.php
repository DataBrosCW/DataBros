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