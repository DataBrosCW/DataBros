<?php

class UserCategoriesModel extends Model
{
    /**
     * SQL Table
     */
    public $table = 'user_categories';

    /**
     * List of public fields (that me be passed to view, or mass updated)
     */
    public $public_fields = [
        'user_id',
        'category_id',
        'followed',
        'count'
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
        'followed'   => 'bool',
    ];

    /**
     * Mutators
     */

    /**
     * Update object in database
     */
    public function update()
    {
        // 1 - We prepare the query
        $listOfPublicProperties = implode( ", ", $this->public_fields );
        $listOfPrivateProperties = implode( ", ", $this->private_fields );

        $valuesCount = count( $this->public_fields ) + count( $this->private_fields );

        $this->sql_query = 'UPDATE ' . $this->table . ' SET ';

        foreach ( $this->public_fields as $field ) {
            if (is_bool($this->{$field})){
                $this->{$field}?array_push($this->sql_values,1):array_push($this->sql_values,0);
            } else {
                array_push( $this->sql_values, $this->{$field} );
            }
            $this->sql_query .= $field.' = ?';
            if ($field !== end($this->public_fields)) $this->sql_query .=', ';

        }
        foreach ( $this->private_fields as $field ) {
            if (is_bool($this->{$field})){
                $this->{$field}?array_push($this->sql_values,1):array_push($this->sql_values,0);
            } else {
                array_push( $this->sql_values, $this->{$field} );
            }
            $this->sql_query .= $field.' = ?';
            if ( $field !== end($this->public_fields)) $this->sql_query .=', ';
        }
        $this->sql_query.=' ';

        // Specify where
        $this->where('user_id',$this->user_id)->where('category_id',$this->category_id);
        $this->sql_query.=';';


        // 3 - We run the query
        try {
            $this->db->prepare( $this->sql_query );
            $this->db->execute( $this->sql_values );
        } catch ( PDOException $e ) {
            throw $e;
        }

        // 4 - We retrieve the id
        $this->{$this->getKeyName()} = $this->db->lastInsertedId();

        return true;
    }

}