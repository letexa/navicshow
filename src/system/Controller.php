<?php

namespace navic;

use navic\exception\NavException;

/**
 * Базовый класс контроллер
 * 
 */
class Controller {
    
    public $controller;
    
    public $action;
    
    public $params;
    
    protected $request;
    
    protected $response;
    
    public function __construct($install) 
    {
        $this->request = $install->request;
        $this->response = $install->response;
        $this->controller = $install->controller;
        $this->action = $install->action;
        $this->params = $this->request->getQueryParams();
    }
            
    
}