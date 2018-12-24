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
        $config = new \vakata\config\Config([ 'key' => 'value' ]);
        $config->fromFile('.env');
        $this->trueToken = $config->get('TOKEN');
        
        $this->falseToken = StringGenerator::randomAlnum(70);
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
        /**
         * Правильный токен
         */
        $I->sendGET('/?authorization='.md5($this->trueToken));
        $I->seeResponseCodeIs(200);
        
        /**
         * Не правильный токен
         */
        $I->sendGET('/?authorization='.md5($this->falseToken));
        $I->seeResponseCodeIs(401);
    }
}
