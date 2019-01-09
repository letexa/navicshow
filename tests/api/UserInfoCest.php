<?php 

use app\model\Role;

/**
 * Информация о текущем пользователе
 * 
 */
class UserInfoCest
{
    
    public function _before(ApiTester $I)
    {
        
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
        $I->sendGET('/user/info', ['authorization' => $I->getAdminToken()]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['username' => 'admin', 'role' => Role::ADMIN]);
        
        $I->sendGET('/user/info', ['authorization' => $I->getUserToken()]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['username' => 'user', 'role' => Role::USER]);
    }
}
