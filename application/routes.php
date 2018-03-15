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

//    =============== Content Routes ==============

//    ------------ Feed ---------------

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

    // ---------- Categories --------
    '/categories' => [
        'GET' => [
            'action'=>'CategoriesController@index',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],
    '/categories/update' => [
        'GET' => [
            'action'=>'CategoriesController@update',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],
//    '/categories/update/{id:\d+}' => [
//        'GET' => [
//            'action'=>'CategoriesController@updateCategory',
//            'auth' => true,
//            'ebay-auth' => true
//        ]
//    ],
    '/categories/{id:\d+}' => [
        'GET' => [
            'action'=>'CategoriesController@show',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],
    '/categories/{id:\d+}/favourite' => [
        'GET' => [
            'action'=>'CategoriesController@favourite',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],

    // ----------- Followed product -------
    '/followed-products' => [
        'GET' => [
            'action'=>'ProductController@followed',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],
    '/products/search/{search}' => [
        'GET' => [
            'action'=>'ProductController@search',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],
    '/products/{id:\d+}' => [
        'GET' => [
            'action'=>'ProductController@show',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],
    '/products/old/{id:\d+}' => [
        'GET' => [
            'action'=>'ProductController@showOld',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],
    '/products/{id:\d+}/favourite' => [
        'GET' => [
            'action'=>'ProductController@favourite',
            'auth' => true,
            'ebay-auth' => true
        ]
    ],


//    ================= Cron Jobs ==============

    '/cron/daily' => [
        'GET' => [
            'action'=>'CronController@daily',
        ]
    ],
    '/cron/test' => [
        'GET' => [
            'action'=>'CronController@test',
        ]
    ],

];