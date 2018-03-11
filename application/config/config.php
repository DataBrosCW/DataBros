<?php

/**
 * Configuration file of Databros
 *
 * You can access a value by using the helper config('a.b.c')
 * where c is array b, itself in array a
 *
 */


return [

    'environment' => getenv('APP_ENV')?:'production',

    'database' => [
        // Connection type is either pdo of mysqli
        'connection_type' => getenv('DB_CONNECTION_TYPE')?:'pdo',

        'driver'      => 'mysql',
        'host'        => getenv('DB_HOST')?:'localhost',
        'port'        => getenv('DB_PORT')?:'8889',
        'db_name'     => getenv('DB_NAME')?:'databros',
        'unix_socket' => '',
        'charset'     => 'utf8mb4',

        'user'     => getenv('DB_USER')?:'databros',
        'password' => getenv('DB_PWD')?:'databros',
    ],

    'app_key' => 'oijwef893520kf=-32',
    'app_url' => getenv('APP_URL')?:'http://localhost:8888/',

    'ebay' => [

        'client_id'     => getenv('EBAY_APP_ID')?:'GermanMi-sampleap-PRD-3df6c4a45-ccf46d3f',
        'redirect_uri'  => getenv('EBAY_REDIRECT_URI')?:'German_Mikulski-GermanMi-sample-daeapvono',
        'response_type' => 'code',
        'scope'         => 'https://api.ebay.com/oauth/api_scope/sell.account',

        'base_url' => getenv('EBAY_BASE_URL')?:'https://api.ebay.com',

        'headers' => [
            'token_auth'        => [
                'Content-Type'  => 'application/x-www-form-urlencoded',
                'Authorization' => getenv('EBAY_APP_CALL_AUTH')?:'Basic R2VybWFuTWktc2FtcGxlYXAtUFJELTNkZjZjNGE0NS1jY2Y0NmQzZjpQUkQtZGY2YzRhNDU5NWU5LTMwYWUtNDYxNy05OGYyLTQzYTY='
            ],
            'search'            => [
                'Authorization' => 'Bearer ' . '__appToken__'
            ],
            'get_item'          => [
                'Authorization' => 'Bearer ' . '__appToken__'
            ],
            'categories_update' => [
                'Content-Type'                   => 'text/xml',
                'X-EBAY-API-COMPATIBILITY-LEVEL' => '1045',
                'X-EBAY-API-IAF-TOKEN'           => '__userToken__',
                'X-EBAY-API-SITEID'              => 0,
                'X-EBAY-API-CALL-NAME'           => 'GetCategories',
            ],
            'get_merchandised'            => [
                'Authorization' => 'Bearer ' . '__appToken__'
            ],

        ],

        'endpoints' => [
            'token_auth'        => '/identity/v1/oauth2/token',
            'search'            => '/buy/browse/v1/item_summary/search',
            'user_token'        => getenv('APP_ENV')=='production'?'https://auth.ebay.com/oauth2/authorize':'https://auth.ebay.com/oauth2/authorize',
            'get_item'          => '/buy/browse/v1/item/',
            'categories_update' => '/ws/api.dll',
            'get_merchandised'  => '/buy/marketing/v1_beta/merchandised_product'
        ],


    ]

];