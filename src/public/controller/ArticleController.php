<?php

namespace app\controller;

use navic\Controller;
use app\model\Article;
use app\iterators\ArticleList;

class ArticleController extends Controller {
    
    public function indexAction($id)
    {
        try {
            $article = Article::find($id);
            $this->message = [
                'id' => $article->id,
                'title' => $article->title,
                'text' => $article->text,
                'category_id' => $article->category_id,
                'created' => $article->created,
                'updated' => $article->updated
            ];
            return $this;
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return (object)['code' => 404, 'message' => 'Article not found'];
        }
    }
    
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
        
        return (object)['code' => $this->code, 'message' => $this->message];
    }
    
    public function listAction()
    {
        $params = $this->request->getQueryParams();
        $limit = !empty($params['limit']) ? $params['limit'] : 10;
        if ($limit && !empty($params['offset'])) {
            $offset = $params['offset'] > 0 ? ($params['offset'] - 1) * $limit : 0;
            $data['limit'] = $limit;
            $data['offset'] = $offset;
        }

        try {
            $data = new \stdClass();
            $data->code = $this->code;
            $articles = Article::find('all', ['limit' => $limit, 'offset' => $offset, 'order' => 'id DESC']);
            $data->message = ArticleList::get($articles);
            return $data;
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return (object)['code' => 404, 'message' => 'Articles not found'];
        }
    }
    
    public function updateAction()
    {
        try {
            $article = Article::find($this->request->getParsedBodyParam('id'));
            $article->title = $this->request->getParsedBodyParam('title') ?: $article->title;
            $article->text = $this->request->getParsedBodyParam('text') ?: $article->text;
            $article->category_id = $this->request->getParsedBodyParam('category_id') ?: $article->category_id;
            $result = $article->save();
            
            if($result !== true) {
                $this->code = 400;
                $this->message = $result;
            }

            return (object)['code' => $this->code, 'message' => $this->message];
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return (object)['code' => 404, 'message' => 'Article not found'];
        }
    }
    
    public function deleteAction()
    {
        try {
            $article = Article::find($this->request->getParsedBodyParam('id'));
            $article->delete();
            return (object)['code' => $this->code, 'message' => $this->message];
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return (object)['code' => 404, 'message' => 'Article not found'];
        }
    }

    public function countAction()
    {
        try {
            $result = Article::count();
            return (object)['code' => $this->code, 'message' => $result];
        } catch (\Exception $ex) {
            return (object)['code' => $ex->getCode(), 'message' => $ex->getMessage()];
        }
    }    
}