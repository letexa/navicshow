<?php

ActiveRecord\Config::initialize(function($cfg)
{
    require _PATH_ . '/resources/config.php';
    
    $cfg->set_model_directory(_APPLICATION_ . '/model');
    $cfg->set_connections([
            'development' => 'mysql://'.$config->get('DB_USERNAME').':'.$config->get('DB_PASSWORD').'@'.$config->get('DB_HOST').'/'.$config->get('DB_DATABASE'),
            'test' => 'mysql://'.$config->get('TEST_DB_USERNAME').':'.$config->get('TEST_DB_PASSWORD').'@'.$config->get('TEST_DB_HOST').'/'.$config->get('TEST_DB_DATABASE'),
            'production' => 'mysql://'.$config->get('DB_USERNAME').':'.$config->get('DB_PASSWORD').'@'.$config->get('DB_HOST').'/'.$config->get('DB_DATABASE')
        ]
    );
    $cfg->set_default_connection($config->get('ENV'));
});