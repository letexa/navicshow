<?php

namespace app\model;

use Symfony\Component\Validator\Constraints as Assert;
use app\validator\Constraints as AcmeAssert;


class Article extends \navic\Model {
    
    const TABLE_NAME = 'articles';
    
    const TITLE_MIN = 3;
    
    const TITLE_MAX = 255;
    
    const TEXT_MIN = 100;
    
    const TEXT_MAX = 10000;

    const PREVIEW = 200;
    
    /*
     * Для ORM валидации
     */
    static $validates_length_of = [
        ['title', 'within' => [self::TITLE_MIN, self::TITLE_MAX]],
        ['text', 'within' => [self::TEXT_MIN, self::TEXT_MAX]]
    ];
    
    static $validates_numericality_of = [
        ['category_id', 'greater_than' => 0]
    ];
    
    static $belongs_to = [
        ['category', 'foreign_key' => 'category_id', 'class_name' => 'Category']
    ];

    public function save($validate = true) {

        $preview = strip_tags($this->text);
        $preview = substr($preview, 0, self::PREVIEW);
        $preview = rtrim($preview, '!,.-');
        $this->preview = substr($preview, 0, strrpos($preview, ' ')) . '...';
        
        $this->violations = [
            'title' => $this->validator->validate($this->title, [
                new Assert\Length(['min' => self::TITLE_MIN, 'max' => self::TITLE_MAX]),
                new Assert\NotBlank(),
            ]),
            'text' => $this->validator->validate($this->text, [
                new Assert\Length(['min' => self::TEXT_MIN, 'max' => self::TEXT_MAX]),
                new Assert\NotBlank(),
            ]),
            'category_id' => $this->validator->validate($this->category_id, [
                new Assert\NotBlank(),
                new AcmeAssert\CategoryExistence
            ]),
            'preview' => $this->validator->validate($this->preview, [
                new Assert\NotBlank(),
            ])
        ];

        
        return parent::save($validate);
    }
    
}