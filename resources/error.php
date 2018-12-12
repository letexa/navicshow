<?php

if ($config->get('ENV') == 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $configuration = [
        'settings' => [
            'displayErrorDetails' => true,
        ],
    ];
    $c = new \Slim\Container($configuration);
}
