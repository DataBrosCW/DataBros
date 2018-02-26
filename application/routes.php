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
            'ebay-auth' => true
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
    '/logout' => [
        'GET' => [
            'action'=>'AuthController@logout',
        ]
    ],
    '/authorize' => [
        'GET' => [
            'action'=>'HomeController@authorize',
            'auth' => true,
        ]
    ],
    '/authorize-receive' => [
        'GET' => [
            'action'=>'HomeController@authorizeReceive',
            'auth' => true,
        ]
    ],



    '/test' => [
        'GET' => [
            'action'=>'HomeController@test',
        ]
    ],

];