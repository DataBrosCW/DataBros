<?php

class ProductStatsModel extends Model
{

    CONST AVG_PRICE = 'avg_price';


    /**
     * SQL Table
     */
    public $table = 'product_stats';

    /**
     * List of public fields (that me be passed to view, or mass updated)
     */
    public $public_fields = [
        'product_id',
        'graph_type',
        'content',
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
        'graph_type' => 'string',
        'content' => '',
    ];

    /**
     * Mutators
     */


}