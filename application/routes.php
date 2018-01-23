<?php

/**
 * List of the routes used in Databros
 * For each routes, you can have various http methods
 * And for each http method you must precise an action
 */

return [
    '/' => [
        'GET' => [
            'action'=>'HomeController@index',
        ],
        'POST' => [
            'action'=>'HomeController@index',
        ]
    ],
    '/test' => [
        'GET' => [
            'action'=>'HomeController@index',
        ]
    ],
];