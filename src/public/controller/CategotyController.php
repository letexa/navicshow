<?php

namespace app\controller;

use navic\Controller;
use app\model\Category;
use app\iterators\CategoryList;

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
            return $this->response->withStatus(404)->withJson(['code' => 404, 'message' => 'Category not found']);
        }
    }
    
    public function listAction()
    {
        $params = $this->request->getQueryParams();
        $limit = $params['limit'];
        $offset = $params['offset'];

        try {
            $categories = Category::find('all', ['limit' => $limit ?: 10, 'offset' => $offset ?: 0, 'order' => 'id DESC']);
            return $this->response->withJson(['code' => $this->code, 'message' => CategoryList::get($categories)]);
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return $this->response->withStatus(404)->withJson(['code' => 404, 'message' => 'Categories not found']);
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

