<?php
use Slim\Middleware\TokenAuthentication;
use app\model\User;

$authenticator = function($request, TokenAuthentication $tokenAuth) {

    $token = $tokenAuth->findToken($request);
    $user = User::find('one', ['token' => $token]);
    print_r($user);
};