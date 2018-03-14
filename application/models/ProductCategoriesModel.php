<?php

class ProductCategoriesModel extends Model
{


    /**
     * SQL Table
     */
    public $table = 'product_categories';

    /**
     * List of public fields (that me be passed to view, or mass updated)
     */
    public $public_fields = [
        'product_id',
        'category_id'
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
        'product_id' => 'double',
        'category_id' => 'double'
    ];

    /**
     * Mutators
     */


}