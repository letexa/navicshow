<?php

namespace app\iterators;

/**
 * Итератор для списка статей
 * 
 */

class ArticleList implements \Iterator {
    
    private $articles;
    
    private $position = 0;
    
    public function __construct($articles) 
    {
        $this->articles = $articles;
        $this->position = 0;
    }
    
    public static function get($articles)
    {
        $result = [];
        $iterator = new self($articles);
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
        $current = $this->articles[$this->position];
        
        $item->id = $current->id;
        $item->title = $current->title;
        $item->text = $current->text;
        $item->preview = $current->preview;
        $item->category_id = $current->category_id;
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
        return isset($this->articles[$this->position]);
    }
}