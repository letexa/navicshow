<?php 

use app\model\Category;

/**
 * Добавление категории
 * 
 */
class CategoryCest
{
    
    public function _before(ApiTester $I)
    {

    }

    // tests
    public function tryToTest(ApiTester $I)
    {
        $I->sendPUT('/category/create?authorization='.$I->getAdminToken(), ['name' => 'First test category']);
        $I->seeResponseCodeIs(200);
        $I->seeInDatabase(Category::TABLE_NAME, ['name' => 'First test category']);
        
        $I->sendPUT('/category/create?authorization='.$I->getAdminToken(), ['name' => 'Second test category']);
        $I->seeResponseCodeIs(200);
        $I->seeInDatabase(Category::TABLE_NAME, ['name' => 'Second test category']);
        
        $I->sendPOST('/category/create?authorization='.$I->getAdminToken(), ['name' => 'Test category whith POST']);
        $I->seeResponseCodeIs(400);
        $I->dontSeeInDatabase(Category::TABLE_NAME, ['name' => 'Test category whith POST']);
        
        $I->sendPUT('/category/create?authorization='.$I->getUserToken(), ['name' => 'Test category from user']);
        $I->seeResponseCodeIs(403);
        $I->dontSeeInDatabase(Category::TABLE_NAME, ['name' => 'Test category from user']);
    }
}
