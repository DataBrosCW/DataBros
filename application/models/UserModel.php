<?php

class UserModel extends Model
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

    /**
     * Mutators
     */

    public function getFullName(){
        return $this->first_name . ' ' .$this->last_name;
    }

    public function followedProducts(){
        $userProducts =  UserProductsModel::instantiate()->where('user_id',$this->id)->where('followed',1)->get();

        if (is_array($userProducts)) {
            $products = [];
            foreach ( $userProducts as $userProduct ) {
                array_push( $products, ProductModel::instantiate()->find( $userProduct->product_id ) );
            }
            return $products;
        } elseif(is_null($userProducts)){
            return null;
        } else {
            return [ ProductModel::instantiate()->find( $userProducts->product_id )];
        }
    }

}