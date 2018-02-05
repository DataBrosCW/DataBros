<?php

namespace application\models;

class UserModel extends \Model
{
    /**
     * SQL Table
     */
    public $table = 'users';

    /**
     * List of public fields (that me be passed to view, or mass updated)
     */
    public $public_fields = [
        'first_name',
        'last_name',
        'email'
    ];

    /**
     * List of private or hidden fields (user password for instance)
     */
    public $private_fields = [
        'password'
    ];

    /**
     * Value casting of each attributes (not all fields must be cast)
     */
    public $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'password' => 'string'
    ];

}