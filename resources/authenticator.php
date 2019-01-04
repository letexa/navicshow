<?php
use navic\TokenAuthentication;
use app\exception\UnauthorizedException;
use app\model\User;

$authenticator = function($request, TokenAuthentication $tokenAuth) {
    
    $token = $tokenAuth->findToken($request);
    $user = User::find('one', ['token' => md5($token)]);

    if (!$user) {
        throw new UnauthorizedException('Invalid Token');
    }
    
    $map = require_once __DIR__ . '/map.php';
    $uri = $request->getUri()->getPath();
    
    if (substr($uri, -1) == '/') {
        $uri = substr($uri, 0, (iconv_strlen - 1));
    }
    
    if (!empty($map[$uri]) || !empty($map[$uri . '/'])) {
        $item = $map[$uri];

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