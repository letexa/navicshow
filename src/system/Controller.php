<?php

namespace navic;

use app\exception\NavException;

/**
 * Базовый класс контроллер
 * 
 */
class Controller {
    
    public $controller;
    
    public $action;
    
    protected $request;
    
    protected $response;
    
    protected $__requestMethods = array();
    
    protected $__access = array();
    
    public function __construct($install) 
    {
        $this->request = $install->request;
        $this->response = $install->response;
        $this->controller = $install->controller;
        $this->action = $install->action;
        
        if (isset($this->__requestMethods[$this->action]) && !$this->request->isMethod($this->__requestMethods[$this->action])) {
            throw new NavException('Bad Request', 400, $this->response);
        }
        
        if (!isset($this->__requestMethods[$this->action]) && !$this->request->isMethod('GET')) {
            throw new NavException('Bad Request', 400, $this->response);
        }
    }
            
    
}