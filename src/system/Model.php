<?php

namespace navic;

use Symfony\Component\Validator\Validation;

class Model extends \ActiveRecord\Model { 
    
    public $errors = array();
    
    protected $validator;
    
    protected $violations;
    
    public function __construct(array $attributes = array(), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
        parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);
        $this->validator = Validation::createValidator();
    }

    public function save($validate=true)
    {
        if (count($this->violations)) {
            foreach($this->violations as $violation) {
                $this->errors[] = $violation->getMessage();
            }
            return $this->errors;
        } else {
            parent::save($validate);
        }
        
        return true;
    }
}