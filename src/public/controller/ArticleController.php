<?php

namespace app\controller;

use navic\Controller;
use app\model\Article;

class ArticleController extends Controller {
    
    public function createAction()
    {
        $article = new Article();
        $article->title = $this->request->getParsedBodyParam('title');
        $article->text = $this->request->getParsedBodyParam('text');
        $article->category_id = $this->request->getParsedBodyParam('category_id');
        $result = $article->save();
        
        if($result !== true) {
            $this->code = 400;
            $this->message = $result;
        }
        
        return $this->response->withStatus($this->code)->withJson(['code' => $this->code, 'message' => $this->message]);
    }
    
}