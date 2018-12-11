<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';

define('_NAMESPACE_', 'app\\controller\\');

$app = new \Slim\App;
$app->any('[/{params:.*}]', function (Request $request, Response $response, array $args) {
    $params = explode('/', $args['params']);
    
    $controller = _NAMESPACE_ . ucfirst($params[0] ?: 'index') . 'Controller';
    $action = ($params[1] ?: 'index') . 'Action';
    
    unset($params[0]);
    unset($params[1]);
    
    if (method_exists($controller, $action)) {
        try {
            $obj = new $controller($response);
            return call_user_func_array([$obj, $action], $params);
        } catch (Exception $ex) {}
    } else {
        return $response->withStatus(404)
                        ->withHeader('Content-Type', 'application/json')
                        ->write(json_encode([
                            'code' => 404, 
                            'response' => 'Not found'
                        ]));
    }
});
$app->run();
