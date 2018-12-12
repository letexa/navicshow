<?php

$config = new \vakata\config\Config([ 'key' => 'value' ]);
$config->fromFile('config.env');

// Framework bootstrap code here
//require_once __DIR__ . '/config/bootstrap.php';

// Get PDO object
$pdo = new PDO(
    'mysql:host='.$config->get('DB_HOST').';dbname='.$config->get('DB_DATABASE').';charset=utf8', $config->get('DB_USERNAME'), $config->get('DB_PASSWORD'),
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8 COLLATE utf8_unicode_ci',
    )
);

// Get migration path for phinx classes
$migrationPath = __DIR__ . '/resources/migrations';

return [
    'paths' => [
        'migrations' => $migrationPath,
    ],
    'foreign_keys' => false,
    'environments' => [
        'default_database' => 'local',
        'local' => [
            // Database name
            'name' => $pdo->query('select database()')->fetchColumn(),
            'connection' => $pdo,
        ]
    ]
];