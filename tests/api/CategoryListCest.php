<?php 

/**
 * Список категорий
 * 
 */
class CategoryListCest
{
    
    public function _before(ApiTester $I)
    {

    }

    // tests
    public function tryToTest(ApiTester $I)
    {
        // Добавить 20 новых категорий
        for ($i = 20; $i > 0; $i--) {
            $I->sendPUT('/category/create?authorization='.$I->getAdminToken(), ['name' => 'Test category '.$i]);
        }
        
        // Limit 10
        $I->sendGET('/category/list?authorization='.$I->getUserToken(), ['limit' => 10]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        for ($i = 1; $i < 11; $i++) {
            $I->seeResponseContainsJson(['name' => 'Test category '.$i]);
        }
        for ($i = 11; $i < 21; $i++) {
            $I->dontSeeResponseContainsJson(['name' => 'Test category '.$i]);
        }
        
        // Limit 5
        $I->sendGET('/category/list?authorization='.$I->getUserToken(), ['limit' => 5]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        for ($i = 1; $i < 6; $i++) {
            $I->seeResponseContainsJson(['name' => 'Test category '.$i]);
        }
        for ($i = 6; $i < 21; $i++) {
            $I->dontSeeResponseContainsJson(['name' => 'Test category '.$i]);
        }
        
        // Offset 7
        $I->sendGET('/category/list?authorization='.$I->getUserToken(), ['limit' => 10, 'offset' => 7]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        for ($i = 1; $i < 8; $i++) {
            $I->dontSeeResponseContainsJson(['name' => 'Test category '.$i]);
        }
        for ($i = 8; $i < 18; $i++) {
            $I->seeResponseContainsJson(['name' => 'Test category '.$i]);
        }
        for ($i = 18; $i < 21; $i++) {
            $I->dontSeeResponseContainsJson(['name' => 'Test category '.$i]);
        }
    }
}
