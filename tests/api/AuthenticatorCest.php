<?php 
use Sinergi\Token\StringGenerator;

/**
 * Тестирование авторизации через токен
 * 
 */
class AuthenticatorCest
{
    private $falseToken;
    
    public function _before(ApiTester $I)
    {
        $this->falseToken = StringGenerator::randomAlnum(70);
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
        /**
         * Правильный токен
         */
        $I->sendGET('/', ['authorization' => $I->getUserToken()]);
        $I->seeResponseCodeIs(200);
        
        /**
         * Не правильный токен
         */
        $I->sendGET('/', ['authorization' => $this->falseToken]);
        $I->seeResponseCodeIs(401);
    }
}
