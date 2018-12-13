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
        $token = $I->grabColumnFromDatabase('users', 'token', ['username' => 'admin']);
        if (!empty($token[0])) {
            $this->trueToken = $token[0];
        }
        
        $this->falseToken = StringGenerator::randomAlnum(70);
        echo $this->falseToken;
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
        /**
         * Правильный токен
         */
        $I->sendGET('/?authorization='.$this->trueToken);
        $I->seeResponseCodeIs(200);
        
        /**
         * Не правильный токен
         */
        $I->sendGET('/?authorization='.$this->falseToken);
        $I->seeResponseCodeIs(401);
    }
}
