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
            return $this->response->withJson(['code' => $this->code, 'message' => $this->message]);
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return $this->response->withStatus(404)->withJson(['code' => 404, 'message' => 'Article not found']);
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
        
        return $this->response->withStatus($this->code)->withJson(['code' => $this->code, 'message' => $this->message]);
    }
    
    public function listAction()
    {
        $params = $this->request->getQueryParams();
        $limit = $params['limit'];
        $offset = $params['offset'];

        try {
            $articles = Article::find('all', ['limit' => $limit ?: 10, 'offset' => $offset ?: 0, 'order' => 'id DESC']);
            return $this->response->withJson(['code' => $this->code, 'message' => ArticleList::get($articles)]);
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return $this->response->withStatus(404)->withJson(['code' => 404, 'message' => 'Articles not found']);
        }
    }
    
    public function updateAction()
    {
        $params = $this->request->getParsedBodyParam();
        try {
            $article = Article::find($params['id']);
            $article->title = $params['title'] ?: $article->title;
            $article->text = $params['text'] ?: $article->text;
            $article->category_id = $params['category_id'] ?: $article->category_id;
            $result = $article->save();
            
            if($result !== true) {
                $this->code = 400;
                $this->message = $result;
            }

            return $this->response->withStatus($this->code)->withJson(['code' => $this->code, 'message' => $this->message]);
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return $this->response->withStatus(404)->withJson(['code' => 404, 'message' => 'Article not found']);
        }
    }
    
    public function deleteAction()
    {
        try {
            $article = Article::find($this->request->getParsedBodyParam('id'));
            $article->delete();
            return $this->response->withJson(['code' => $this->code, 'message' => $this->message]);
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return $this->response->withStatus(404)->withJson(['code' => 404, 'message' => 'Article not found']);
        }
    }
    
}