<?php

namespace app\controller;

use navic\Controller;
use app\model\Role;

class CategoryController extends Controller {
    
    protected $__requestMethods = [
        'create' => 'PUT'
    ];
    
    protected $__access = [
        'create' => Role::ADMIN
    ];
    
    public function createAction()
    {
        echo 'hello';
    }
}

