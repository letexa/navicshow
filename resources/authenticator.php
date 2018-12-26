<?php
use Slim\Middleware\TokenAuthentication;
use app\exception\UnauthorizedException;
use app\model\User;

$authenticator = function($request, TokenAuthentication $tokenAuth) {
    
    $token = $tokenAuth->findToken($request);
    $user = User::find('one', ['token' => md5($token)]);
    
    if (!$user) {
        throw new UnauthorizedException('Invalid Token');
    }

    $map = require_once __DIR__ . '/map.php';
    if (!empty($map[$request->getUri()->getPath()])) {
        $item = $map[$request->getUri()->getPath()];
        
        if (isset($item['method']) && !$request->isMethod($item['method'])) {
            throw new UnauthorizedException('Bad Request', 400);
        }
        
        if (!isset($item['method']) && !$request->isMethod('GET')) {
            throw new UnauthorizedException('Bad Request', 400);
        }
        
        if (isset($item['access']) && $user->role < $item['access']) {
            throw new UnauthorizedException('Forbidden', 403);
        }
    }
    
};