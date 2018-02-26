<?php

/**
 * Configuration file of Databros
 *
 * You can access a value by using the helper config('a.b.c')
 * where c is array b, itself in array a
 *
 */


return [

    'database' => [
        'driver'      => 'mysql',
        'host'        => 'localhost',
        'port'        => '8889',
        'db_name'     => 'databros',
        'unix_socket' => '',
        'charset'     => 'utf8mb4',

        'user'        => 'databros',
        'password'    => 'databros',
    ],

    'app_key' => 'oijwef893520kf=-32',
    'app_url' => 'http://localhost:8888/',

    'ebay' => [

        'client_id'=>'GermanMi-sampleap-SBX-65d705b3d-772ae4f4',
        'redirect_uri' => 'German_Mikulski-GermanMi-sample-amcujbjxm',
        'response_type' => 'code',
        'scope' => 'https://api.ebay.com/oauth/api_scope/sell.account',

        'base_url' => 'https://api.sandbox.ebay.com',

        'headers' => [
            'token_auth' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization'=> 'Basic R2VybWFuTWktc2FtcGxlYXAtU0JYLTY1ZDcwNWIzZC03NzJhZTRmNDpTQlgtNWQ3MDViM2RmMmJiLTg4MDgtNDNkNS05ZDgyLTViMjE='
            ],
            'search' => [
                'Authorization'=> 'Bearer ' . '__appToken__'
            ]
        ],

        'endpoints' => [
            'token_auth' => '/identity/v1/oauth2/token',
            'search'     => '/buy/browse/v1/item_summary/search?q=phone',
            'user_token' => 'https://auth.sandbox.ebay.com/oauth2/authorize'
        ],

    ]

];