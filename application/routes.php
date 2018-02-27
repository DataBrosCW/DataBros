<?php

/**
 * List of the routes used in Databros
 * For each routes, you can have various http methods
 * And for each http method you must precise an action
 */

return [
    '/' => [
        'GET' => [
            'action'=>'HomeController@index'
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
            'ebay-auth' => false
        ]
    ],

//    ------------ Content Routes ---------------
    '/feed' => [
        'GET' => [
            'action'=>'FeedController@index',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],
    '/feed/preferences' => [
        'GET' => [
            'action'=>'FeedController@preferences',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],
    '/categories' => [
        'GET' => [
            'action'=>'CategoriesController@index',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],
    '/categories/example' => [
        'GET' => [
            'action'=>'CategoriesController@show',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],
    '/just-for-you' => [
        'GET' => [
            'action'=>'JustForYouController@index',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],

    '/products/example' => [
        'GET' => [
            'action'=>'ProductController@show',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],

    '/products/search' => [
        'POST' => [
            'action'=>'ProductController@search',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],





    '/test' => [
        'GET' => [
            'action'=>'HomeController@test',
        ]
    ],

];