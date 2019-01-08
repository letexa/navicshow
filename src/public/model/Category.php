<?php

namespace app\model;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class Category extends \navic\Model {
    
    const TABLE_NAME = 'categories';
    
    const NAME_MIN = 3;
    
    const NAME_MAX = 255;
    
    /*
     * Для ORM валидации
     */
    static $validates_length_of = [
        ['name', 'within' => [self::NAME_MIN, self::NAME_MAX]]
    ];

    public function save($validate = true) {
        
        $this->violations = [
            'name' => $this->validator->validate($this->name, [
                new Length(['min' => self::NAME_MIN, 'max' => self::NAME_MAX]),
                new NotBlank(),
            ])
        ];
        
        return parent::save($validate);
    }
    
}