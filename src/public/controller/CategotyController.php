<?php

namespace app\controller;

use navic\Controller;
use app\model\Category;

class CategoryController extends Controller {
    
    public function indexAction($id)
    {
        try {
            $category = Category::find($id);
            $this->message = [
                'id' => $category->id,
                'name' => $category->name,
                'created' => $category->created,
                'updated' => $category->updated
            ];
            return $this->response->withJson(['code' => $this->code, 'message' => $this->message]);
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return $this->response->withStatus(404)
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode([
                        'code' => 404, 
                        'message' => 'Category not found'
                    ]));
        }
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
        
        return $this->response->withStatus($this->code)->withJson(['code' => $this->code, 'message' => $this->message]);
    }
    
    public function updateAction()
    {
        try {
            $category = Category::find($this->request->getParsedBodyParam('id'));
            $category->name = $this->request->getParsedBodyParam('name');
            $result = $category->save();
            
            if($result !== true) {
                $this->code = 400;
                $this->message = $result;
            }

            return $this->response->withStatus($this->code)->withJson(['code' => $this->code, 'message' => $this->message]);
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return $this->response->withStatus(404)->withJson(['code' => 404, 'message' => 'Category not found']);
        }
    }
    
    public function deleteAction()
    {
        try {
            $category = Category::find($this->request->getParsedBodyParam('id'));
            $category->delete();
            return $this->response->withJson(['code' => $this->code, 'message' => $this->message]);
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return $this->response->withStatus(404)->withJson(['code' => 404, 'message' => 'Category not found']);
        }
    }
}

