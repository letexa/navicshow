<?php

namespace app\controller;

use navic\Controller;
use app\model\Category;

class CategoryController extends Controller {
    
    public function createAction()
    {
        $category = new Category();
        $category->name = $this->params['name'];
        $category->save();
    }
}

