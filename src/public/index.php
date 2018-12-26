<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Middleware\TokenAuthentication;

require_once '../../vendor/autoload.php';
require_once '../../constant.php';
require_once '../../resources/config.php';
require_once '../../resources/error.php';
require_once '../../resources/active_record.php';
require_once '../../resources/authenticator.php';

$app = new \Slim\App($c);

$app->add(new TokenAuthentication([
    'path' => '/',
    'authenticator' => $authenticator,
    'secure' => true,
    'relaxed' => ['navicshow.loc']
]));

$app->any('[/{params:.*}]', function (Request $request, Response $response, array $args) {
    $params = explode('/', $args['params']);
    
    $install = new stdClass();
    $install->request = $request;
    $install->response = $response;
    $install->controller = ucfirst(!empty($params[0]) ? $params[0] : 'index');
    $install->action = !empty($params[1]) ? $params[1] : 'index';

    unset($params[0]);
    unset($params[1]);
    
    $controller = _NAMESPACE_ . 'controller\\' . $install->controller . 'Controller';
    $action = $install->action . 'Action';
    
    if (method_exists($controller, $action)) {
        try {
            $obj = new $controller($install);
            return call_user_func_array([$obj, $action], $params);
        } catch (Exception $ex) {
            return $response->withStatus($ex->getCode())
                        ->withHeader('Content-Type', 'application/json')
                        ->write(json_encode([
                            'code' => $ex->getCode(), 
                            'message' => $ex->getMessage()
                        ]));
        }
    } else {
        return $response->withStatus(404)
                        ->withHeader('Content-Type', 'application/json')
                        ->write(json_encode([
                            'code' => 404, 
                            'message' => 'Not found'
                        ]));
    }
});
$app->run();
