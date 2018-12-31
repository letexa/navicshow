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
        // Добавление категории
        $I->sendPUT('/category/create?authorization='.$I->getAdminToken(), ['name' => 'Test category']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['code' => 200, 'message' => 'OK']);
        $I->seeInDatabase(Category::TABLE_NAME, ['name' => 'Test category']);
        
        // Добавленрие категории через POST
        $I->sendPOST('/category/create?authorization='.$I->getAdminToken(), ['name' => 'Test category whith POST']);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['code' => 400, 'message' => 'Bad Request', 'token' => $I->getAdminToken()]);
        $I->dontSeeInDatabase(Category::TABLE_NAME, ['name' => 'Test category whith POST']);
        
        // Добавление категории без доступа
        $I->sendPUT('/category/create?authorization='.$I->getUserToken(), ['name' => 'Test category from user']);
        $I->seeResponseCodeIs(403);
        $I->seeResponseContainsJson(['code' => 403, 'message' => 'Forbidden', 'token' => $I->getUserToken()]);
        $I->dontSeeInDatabase(Category::TABLE_NAME, ['name' => 'Test category from user']);
        
        // Редактирование категории

    }
}
