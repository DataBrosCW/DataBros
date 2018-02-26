<?php

class ApplicationTokenModel extends Model
{
    /**
     * SQL Table
     */
    public $table = 'application_tokens';

    /**
     * List of public fields (that me be passed to view, or mass updated)
     */
    public $public_fields = [
        'token',
        'expires_at'
    ];

    /**
     * List of private or hidden fields (user password for instance)
     */
    public $private_fields = [
    ];

    /**
     * Value casting of each attributes (not all fields must be cast)
     */
    public $casts = [
        'token' => 'string',
        'expires_at' => '',
    ];

    /**
     * Mutators
     */


}