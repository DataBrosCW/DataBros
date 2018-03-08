<?php

/**
 * Configuration file of Databros
 *
 * You can access a value by using the helper config('a.b.c')
 * where c is array b, itself in array a
 *
 */


return [

    'environment' => getenv('DB_HOST')?:'local',

    'database' => [
        // Connection type is either pdo of mysqli
        'connection_type' => getenv('DB_CONNECTION_TYPE')?:'pdo',

        'driver'      => 'mysql',
        'host'        => getenv('DB_HOST')?:'127.0.0.1',
        'port'        => getenv('DB_PORT')?:'3306',
        'db_name'     => getenv('DB_NAME')?:'databros',
        'unix_socket' => '',
        'charset'     => 'utf8mb4',

        'user'     => getenv('DB_USER')?:'databros',
        'password' => getenv('DB_PWD')?:'databros',
    ],

    'app_key' => 'oijwef893520kf=-32',
    'app_url' => getenv('APP_URL')?:'http://localhost:8888/',

    'ebay' => [

        'client_id'     => 'GermanMi-sampleap-SBX-65d705b3d-772ae4f4',
        'redirect_uri'  => 'German_Mikulski-GermanMi-sample-amcujbjxm',
        'response_type' => 'code',
        'scope'         => 'https://api.ebay.com/oauth/api_scope/sell.account',

        'base_url' => 'https://api.sandbox.ebay.com',

        'headers' => [
            'token_auth'        => [
                'Content-Type'  => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic R2VybWFuTWktc2FtcGxlYXAtU0JYLTY1ZDcwNWIzZC03NzJhZTRmNDpTQlgtNWQ3MDViM2RmMmJiLTg4MDgtNDNkNS05ZDgyLTViMjE='
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
            ]
        ],

        'endpoints' => [
            'token_auth'        => '/identity/v1/oauth2/token',
            'search'            => '/buy/browse/v1/item_summary/search',
            'user_token'        => 'https://auth.sandbox.ebay.com/oauth2/authorize',
            'get_item'          => '/buy/browse/v1/item/',
            'categories_update' => '/ws/api.dll'
        ],


    ]

];