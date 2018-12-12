<?php
use Slim\Middleware\TokenAuthentication;
use app\exception\UnauthorizedException;
use app\model\User;

$authenticator = function($request, TokenAuthentication $tokenAuth) {

    $token = $tokenAuth->findToken($request);
    $user = User::find('one', ['token' => $token]);
    
    if (!$user) {
        throw new UnauthorizedException('Invalid Token');
        exit;
    }
    
    
};