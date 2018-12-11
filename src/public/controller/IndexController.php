<?php

namespace app\controller;

use navic\Controller;

class IndexController extends Controller {
    
    public function indexAction()
    {
        return $this->response->withStatus(200)
                        ->withHeader('Content-Type', 'application/json')
                        ->write(json_encode([
                            'code' => 200, 
                            'response' => 'This is Navicshow API!'
                        ]));
    }
}

