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
        $I->sendPUT('/category/create', ['token' => $I->getAdminToken(), 'name' => 'Тестовая категория 1']);
        $I->seeResponseCodeIs(200);
        $I->seeInDatabase(Category::TABLE_NAME, ['name' => 'Тестовая категория 1']);
        
        $I->sendPUT('/category/create', ['token' => $I->getAdminToken(), 'name' => 'Тестовая категория 2']);
        $I->seeResponseCodeIs(200);
        $I->seeInDatabase(Category::TABLE_NAME, ['name' => 'Тестовая категория 2']);
        
        $I->sendPUT('/category/create', ['token' => $I->getAdminToken(), 'name' => 'Тестовая категория 3']);
        $I->seeResponseCodeIs(200);
        $I->seeInDatabase(Category::TABLE_NAME, ['name' => 'Тестовая категория 3']);
        
        $I->sendPOST('/category/create', ['token' => $I->getAdminToken(), 'name' => 'Тестовая категория через POST']);
        $I->seeResponseCodeIs(400);
        $I->dontSeeInDatabase(Category::TABLE_NAME, ['name' => 'Тестовая категория через POST']);
        
        $I->sendPUT('/category/create', ['token' => $I->getUserToken(), 'name' => 'Тестовая категория от обычного пользователя']);
        $I->seeResponseCodeIs(403);
        $I->dontSeeInDatabase(Category::TABLE_NAME, ['name' => 'Тестовая категория от обычного пользователя']);
    }
}
