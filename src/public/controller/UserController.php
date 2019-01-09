<?php

namespace app\controller;

use navic\Controller;
use app\model\User;

class UserController extends Controller {
    
    /**
     * Выводит информацию о текущем пользователе
     * @return type
     */
    public function infoAction()
    {
        try {
            $params = $this->request->getQueryParams();
            $user = User::find('one', ['token' => !empty($params['authorization']) ? md5($params['authorization']) : null]);

            return $this->response->withJson([
                'code' => $this->code, 
                'message' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role,
                    'created' => $user->created,
                    'updated' => $user->updated
                ]
            ]);
        } catch (\ActiveRecord\RecordNotFound $ex) {
            return $this->response->withStatus(404)->withJson(['code' => 404, 'message' => 'User not found']);
        }
    }
}