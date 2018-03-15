<?php

class CategoryModel extends Model
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
        'name'
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
        'ebay_id' => '',
        'description' => 'string',
        'name' => 'string',
    ];

    /**
     * Mutators
     */

    /**
     * @return UserCategoriesModel
     */
    public function stats(  )
    {
        return UserCategoriesModel::instantiate()
                                  ->where('user_id',auth_user()->id)
                                  ->where('category_id',$this->id)
                                  ->limit(1)
                                  ->get();
    }

}