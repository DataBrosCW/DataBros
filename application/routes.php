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
    '/register' => [
        'GET' => [
            'action'=>'AuthController@registerPage',
        ],
        'POST' => [
            'action'=>'AuthController@register',
            'csrf' => true
        ]
    ],
    '/login' => [
        'GET' => [
            'action'=>'AuthController@loginPage',
        ],
        'POST' => [
            'action'=>'AuthController@login',
            'csrf' => true
        ]
    ],
];