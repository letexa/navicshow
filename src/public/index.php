<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use navic\TokenAuthentication;

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
    'relaxed' => [$config->get('BASE_URL')],
    'passthrough' => [
        '/uploads'
    ]
]));

define('PROTOCOL', $config->get('PROTOCOL'));
define('BASE_URL', $config->get('BASE_URL'));
define('FULL_BASE_URL', PROTOCOL . '://' . BASE_URL);

$app->get('/category/{id:[0-9]+}', function ($request, $response, $args) {

    $install = new stdClass();
    $install->request = $request;
    $install->response = $response;
    $install->controller = 'Category';
    $install->action = 'index';
    
    $category = new \app\controller\CategoryController($install);
    $data = $category->indexAction($args['id']);
    return $this->response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus($data->code)
            ->withJson(['code' => $data->code, 'message' => $data->message]);
});

$app->get('/article/{id:[0-9]+}', function ($request, $response, $args) {

    $install = new stdClass();
    $install->request = $request;
    $install->response = $response;
    $install->controller = 'Article';
    $install->action = 'indexAction';
    
    $article = new \app\controller\ArticleController($install);
    $data = $article->indexAction($args['id']);
    return $this->response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus($data->code)
            ->withJson(['code' => $data->code, 'message' => $data->message]);
});

$app->get('/uploads/{path:.+}', function ($request, $response, $args) {
    $install = new stdClass();
    $install->request = $request;
    $install->response = $response;
    $install->controller = 'File';
    $install->action = 'indexAction';
    $uploads = new \app\controller\FileController($install);
    $uploads->indexAction($args['path']);
});

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
            $data = call_user_func_array([$obj, $action], $params);
            $response_data = ['code' => $data->code, 'message' => $data->message];

            if ($install->controller == 'File' && $install->action == 'upload') {
                $response_data = $data->message;
            }

            return $this->response
                    ->withHeader('Access-Control-Allow-Origin', '*')
                    ->withStatus($data->code)
                    ->withJson($response_data);
        } catch (Exception $ex) {
            return $this->response->withJson(['code' => $ex->getCode(), 'message' => $ex->getMessage()]);
        }
    } else {
        return $this->response->withStatus(404)->withJson(['code' => 404, 'message' => 'Not found']);
    }
});
$app->run();
