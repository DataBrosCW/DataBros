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
    'app_url' => 'http://localhost:8888/'

];