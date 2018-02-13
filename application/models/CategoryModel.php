<?php

class ProductModel extends Model
{
    /**
     * SQL Table
     */
    public $table = 'categories';

    /**
     * List of public fields (that me be passed to view, or mass updated)
     */
    public $public_fields = [
        'ebay_id',
        'description',
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
        'ebay_id' => 'string',
        'description' => 'string',
    ];

    /**
     * Mutators
     */
    

}