<?php

namespace app\controller;

use navic\Controller;

class IndexController extends Controller {
    
    public function indexAction()
    {
        return $this->response->withJson(['code' => 200, 'response' => 'This is Navicshow API!']);
    }
}

