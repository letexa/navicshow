<?php

namespace app\iterators;

/**
 * Итератор для списка категорий
 * 
 */

class CategoryList implements \Iterator {
    
    private $categories;
    
    private $position = 0;
    
    public function __construct($categories) 
    {
        $this->categories = $categories;
        $this->position = 0;
    }
    
    public static function get($categories)
    {
        $result = [];
        $iterator = new self($categories);
        foreach($iterator as $item) {
            $result[] = $item;
        }
        return $result;
    }
    
    public function rewind()
    {
        $this->position = 0;
    }
    
    public function current()
    {
        $item = new \stdClass();
        $current = $this->categories[$this->position];
        
        $item->id = $current->id;
        $item->name = $current->name;
        $item->created = $current->created;
        $item->updated = $current->updated;
        
        return $item;
    }
    
    public function key()
    {
        return $this->position;
    }
    
    public function next()
    {
        return $this->position ++;
    }
    
    public function valid()
    {
        return isset($this->categories[$this->position]);
    }
}