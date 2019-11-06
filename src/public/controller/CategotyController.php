<?php

namespace app\controller;

use navic\Controller;
use app\model\Category;
use app\iterators\CategoryList;

class CategoryController extends Controller {
    
    public function indexAction($id)
    {
        try {
            // Баг в компоненте php-activerecord поэтому подавляем выводимый warning
            $category = @Category::find($id);
            $this->message = [
                'id' => $category->id,
                'name' => $category->name,
                'created' => $category->created,
                'updated' => $category->updated
            ];
            return (object)['code' => $this->code, 'message' => $this->message];
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return (object)['code' => 404, 'message' => 'Category not found'];
        }
    }
    
    public function listAction()
    {
        $params = $this->request->getQueryParams();
        $data['order'] = 'id DESC';
        $limit = !empty($params['limit']) ? $params['limit'] : 10;
        if ($limit && !empty($params['offset'])) {
            $offset = $params['offset'] > 0 ? ($params['offset'] - 1) * $limit : 0;
            $data['limit'] = $limit;
            $data['offset'] = $offset;
        }

        try {
            $categories = Category::find('all', $data);
            return (object)['code' => $this->code, 'message' => CategoryList::get($categories)];
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return (object)['code' => 404, 'message' => 'Categories not found'];
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
        
        return (object)['code' => $this->code, 'message' => $this->message];
    }
    
    public function updateAction()
    {
        try {
            $category = @Category::find($this->request->getParsedBodyParam('id'));
            $category->name = $this->request->getParsedBodyParam('name');
            $result = $category->save();
            
            if($result !== true) {
                $this->code = 400;
                $this->message = $result;
            }

            return (object)['code' => $this->code, 'message' => $this->message];
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return (object)['code' => 404, 'message' => 'Category not found'];
        }
    }
    
    public function deleteAction()
    {
        try {
            $category = @Category::find($this->request->getParsedBodyParam('id'));
            $category->delete();
            return (object)['code' => $this->code, 'message' => $this->message];
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return (object)['code' => 404, 'message' => 'Category not found'];
        }
    }

    public function countAction()
    {
        try {
            $result = Category::count();
            return (object)['code' => $this->code, 'message' => $result];
        } catch (\Exception $ex) {
            return (object)['code' => $ex->getCode(), 'message' => $ex->getMessage()];
        }
    }
}

