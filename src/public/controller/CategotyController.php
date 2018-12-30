<?php

namespace app\controller;

use navic\Controller;
use app\model\Category;

class CategoryController extends Controller {
    
    public function createAction()
    {
        $category = new Category();
        $category->name = $this->request->getParsedBodyParam('name');
        $result = $category->save();
        
        if($result !== true) {
            $this->code = 400;
            $this->message = $result;
        }
        
        return $this->response->withJson(['code' => $this->code, 'message' => $this->message]);
    }
}

