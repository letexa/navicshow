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
        if (is_array($this->violations)) {
            foreach($this->violations as $key => $violation) {
                if (count($violation)) {
                    foreach ($violation as $item) {
                        $this->errors[][$key] = $item->getMessage();
                    }
                }
            }
        }
        
        if ($this->errors) {
            return ['errors' => $this->errors];
        } else {
            parent::save($validate);
        }
        
        return true;
    }
}