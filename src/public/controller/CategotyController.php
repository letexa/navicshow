<?php

namespace app\controller;

use navic\Controller;
use app\model\Category;

class CategoryController extends Controller {
    
    public function indexAction($id)
    {
        $category = Category::find($id);
        $this->message = [
            'id' => $category->id,
            'name' => $category->name,
            'created' => $category->created,
            'updated' => $category->updated
        ];
        return $this->response->withJson(['code' => $this->code, 'message' => $this->message]);
    }
    
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

