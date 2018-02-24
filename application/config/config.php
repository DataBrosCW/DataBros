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

        'base_url' => 'https://api.sandbox.ebay.com',

        'headers' => [
            'token_auth' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization'=> 'Basic R2VybWFuTWktc2FtcGxlYXAtU0JYLTY1ZDcwNWIzZC03NzJhZTRmNDpTQlgtNWQ3MDViM2RmMmJiLTg4MDgtNDNkNS05ZDgyLTViMjE='
            ]
        ],

        'endpoints' => [
            'token_auth' => '/identity/v1/oauth2/token',
        ],

    ]

];