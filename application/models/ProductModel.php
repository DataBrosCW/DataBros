<?php

class ProductModel extends Model
{
    /**
     * SQL Table
     */
    public $table = 'products';

    /**
     * List of public fields (that me be passed to view, or mass updated)
     */
    public $public_fields = [
        'title',
        'img',
        'epid',
        'description',
        'price'
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
        'epid' => 'string',
        'title' => 'string',
        'img' => 'string',
        'description' => 'string',
        'price' => 'double',
    ];

    /**
     * Mutators
     */


}