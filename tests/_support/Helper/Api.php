<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Api extends \Codeception\Module
{
    protected $requiredFields = ['adminToken', 'userToken'];

    public function getAdminToken() {
        return $this->config['adminToken'];
    }
    
    public function getUserToken() {
        return $this->config['userToken'];
    }
}
