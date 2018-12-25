<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Api extends \Codeception\Module
{
    public $token;
    
    public function __construct(\Codeception\Lib\ModuleContainer $moduleContainer, $config = null) {
        parent::__construct($moduleContainer, $config);
        
        $config = new \vakata\config\Config([ 'key' => 'value' ]);
        $config->fromFile('.env');
        $this->token = $config->get('TOKEN');
    }

    public function getToken() {
        return $this->token;
    }
}
