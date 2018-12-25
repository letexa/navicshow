<?php 
use Sinergi\Token\StringGenerator;

/**
 * Тестирование авторизации через токен
 * 
 */
class AuthenticatorCest
{
    private $trueToken;
    
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
        $I->sendGET('/?authorization='.md5($I->getToken()));
        $I->seeResponseCodeIs(200);
        
        /**
         * Не правильный токен
         */
        $I->sendGET('/?authorization='.md5($this->falseToken));
        $I->seeResponseCodeIs(401);
    }
}
