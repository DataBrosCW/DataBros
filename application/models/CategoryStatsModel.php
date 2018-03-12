<?php

class CategoryStatsModel extends Model
{

    CONST AVG_PRICE = 'avg_price';

    /**
     * SQL Table
     */
    public $table = 'category_stats';

    /**
     * List of public fields (that me be passed to view, or mass updated)
     */
    public $public_fields = [
        'category_id',
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
        'category_id' => 'double',
        'graph_type' => 'string',
        'content' => '',
    ];

    /**
     * Mutators
     */


}