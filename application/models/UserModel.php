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

    public function mostVisitedProduct(){
        // Fine to hardcode user id in request here as it's not a user input
        $result = $this->raw('SELECT product_id FROM user_products WHERE user_id = '.$this->id.' ORDER BY count DESC LIMIT 1;');
        if (isset($result[0]['product_id'])) {
            $product_id = $result[0]['product_id'];
            return ProductModel::instantiate()->find( $product_id );
        }
        return null;
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

    public function followedCategories(){
        $userCategories =  UserCategoriesModel::instantiate()->where('user_id',$this->id)->where('followed',1)->get();

        if (is_array($userCategories)) {
            $categories = [];
            foreach ( $userCategories as $userCategory ) {
                array_push( $categories, CategoryModel::instantiate()->find( $userCategory->category_id ) );
            }
            return $categories;
        } elseif(is_null($userCategories)){
            return null;
        } else {
            return [ CategoryModel::instantiate()->find( $userCategories->category_id )];
        }
    }

}