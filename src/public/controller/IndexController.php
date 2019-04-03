<?php

namespace app\controller;

use navic\Controller;

class IndexController extends Controller {
    
    public function indexAction()
    {
        return (object)['code' => 200, 'message' => 'This is Navicshow API!'];
    }
}

