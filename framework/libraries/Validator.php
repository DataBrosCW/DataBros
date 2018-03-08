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
    public function validate($arrayToValidate=[]){

        if($arrayToValidate==[]) {
            $arrayToValidate = $_REQUEST;
        }

        foreach ($this->rules as $ruleKey => $ruleValue){

            foreach ($ruleValue as $rule){
                // Some method has required parameters
                if (strpos( $rule , ':') !== false) {
                    $methodName = preg_split("/:/", $rule)[0];
                    $methodParameters = preg_split("/:/", $rule)[1];

                    $this->{'rule'.ucfirst($methodName)}($ruleKey,$methodParameters,$arrayToValidate);
                } else {
                    $this->{'rule'.ucfirst($rule)}($ruleKey,$arrayToValidate);
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
    private function ruleRequired($param,$arrayToValidate=[]) {

        if( isset($arrayToValidate[$param]) && $arrayToValidate[$param]!=''){
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
    private function ruleString($param,$arrayToValidate=[]) {


        if( is_string($arrayToValidate[$param]) ){
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
    private function ruleEmail($param,$arrayToValidate=[]) {


        if ( filter_var($arrayToValidate[$param], FILTER_VALIDATE_EMAIL) ){
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
    private function ruleConfirmed($param, $arrayToValidate=[]) {
        $validated = isset($arrayToValidate[$param])
                     && isset($arrayToValidate[$param.'_confirm'])
                     && $arrayToValidate[$param] === $arrayToValidate[$param.'_confirm'];

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
    private function ruleMin($param, $value, $arrayToValidate=[]) {
        $validated = false;
        if (is_string($arrayToValidate[$param])){
            $validated = strlen($arrayToValidate[$param]) >= $value;
        } else {
            $validated = $arrayToValidate[$param] >= $value;
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