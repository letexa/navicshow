<?php

namespace app\controller;

use navic\Controller;
use app\model\Category;

class CategoryController extends Controller {
    
    public function createAction()
    {
        $category = new Category();
        $category->name = $this->params['name'];
        $result = $category->save();
        
        if($result !== true) {
            $this->code = 400;
            $this->message = $result;
        }
        
        return $this->response->withStatus($this->code)
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode([
                        'code' => $this->code, 
                        'message' => $this->message
                    ]));
    }
}

