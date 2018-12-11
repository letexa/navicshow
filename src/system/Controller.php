<?php

namespace navic;

/**
 * Базовый класс контроллер
 * 
 */
class Controller {
    
    protected $response;
    
    public function __construct($response) 
    {
        $this->response = $response;
    }
            
    
}