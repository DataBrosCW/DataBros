<?php

class Validator
{
    private $rules = [];

    private $errors = [];

    /**
     * Constructs a validator,
     */
    public function __construct($rules = [])
    {
        foreach ($rules as $ruleKey => $ruleValue){
            $this->rules[$ruleKey] = explode('|',$ruleValue);
        }
    }

    /**
     * Go through each validation rules and validates
     */
    public function validate(){
        foreach ($this->rules as $ruleKey => $ruleValue){

            foreach ($ruleValue as $rule){
                // Some method has required parameters
                if (strpos( $rule , ':') !== false) {
                    $methodName = preg_split("/:/", $rule)[0];
                    $methodParameters = preg_split("/:/", $rule)[1];

                    $this->{'rule'.ucfirst($methodName)}($ruleKey,$methodParameters);
                } else {
                    $this->{'rule'.ucfirst($rule)}($ruleKey);
                }
            }
        }

        // If some errors were found, validation failed
        if ($this->errors != []){
            return false;
        }
        return true;
    }

    /**
     * Return the list of errors found
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Make sure request contains such param
     */
    private function ruleRequired($param) {
        if( isset($_REQUEST[$param]) && $_REQUEST[$param]!=''){
            return true;
        } else {
            if (!isset($this->errors[$param])) $this->errors[$param] = [];
            array_push( $this->errors[$param],
            'The field is required.'
                );
            return false;
        }
    }

    /**
     * Make sure request's variable is a string
     */
    private function ruleString($param) {
        if( is_string($_REQUEST[$param]) ){
            return true;
        } else {
            if (!isset($this->errors[$param])) $this->errors[$param] = [];
            array_push( $this->errors[$param],
                'The field must be a valid text.'
            );
            return false;
        }
    }

    /**
     * Make sure request's variable is a valid email
     */
    private function ruleEmail($param) {
        if ( filter_var($_REQUEST[$param], FILTER_VALIDATE_EMAIL) ){
            return true;
        } else {
            if (!isset($this->errors[$param])) $this->errors[$param] = [];
            array_push( $this->errors[$param],
                'The field must be a valid email.'
            );
            return false;
        }
    }

    /**
     * Make sure request's variable is confirmed
     *
     * For instance, if password field must be confirmed, then there must be a field password_confirm containing
     * the same value
     */
    private function ruleConfirmed($param) {
        $validated = isset($_REQUEST[$param])
                     && isset($_REQUEST[$param.'_confirm'])
                     && $_REQUEST[$param] === $_REQUEST[$param.'_confirm'];

        if ( $validated ){
            return true;
        } else {
            if (!isset($this->errors[$param])) $this->errors[$param] = [];
            array_push( $this->errors[$param],
                'The field must be a confirmed.'
            );
            return false;
        }
    }

    /**
     * Make sure request's variable has a minimum size (or value if int)
     */
    private function ruleMin($param, $value) {
        $validated = false;
        if (is_string($_REQUEST[$param])){
            $validated = strlen($_REQUEST[$param]) >= $value;
        } else {
            $validated = $_REQUEST[$param] >= $value;
        }

        if ( $validated ){
            return true;
        } else {
            if (!isset($this->errors[$param])) $this->errors[$param] = [];
            array_push( $this->errors[$param],
                'The field must have a minimum of '.$value.'.'
            );
            return false;
        }

    }




}