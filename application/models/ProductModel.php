<?php

class ProductModel extends Model
{
    /**
     * SQL Table
     */
    public $table = 'products';

    /**
     * List of public fields (that can be passed to view, or mass updated)
     */
    public $public_fields = [
        'title',
        'img',
        'epid',
        'description',
        'price',
        'link',
        'subgroup'
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
        'epid' => '',
        'title' => 'string',
        'img' => 'string',
        'description' => 'string',
        'price' => 'double',
        'link' => 'string',
        'subgroup' => 'string'
    ];

    /**
     * Mutators
     */

    public function avg_price_graph()
    {
        return strlen($this->epid) > 17;
    }


}