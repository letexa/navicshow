<?php 

use app\model\Category;
use Sinergi\Token\StringGenerator;

/**
 * CRUD категории
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
        
        // Добавление категории без названия
        $I->sendPUT('/category/create?authorization='.$I->getAdminToken());
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['name' => 'This value should not be blank.']);
        
        // Добавление категории с коротким названием
        $I->sendPUT('/category/create?authorization='.$I->getAdminToken(), ['name' => 'Te']);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['name' => 'This value is too short. It should have 3 characters or more.']);
        
        // Добавление категории с длинным названием
        $I->sendPUT('/category/create?authorization='.$I->getAdminToken(), ['name' => StringGenerator::randomAlnum(260)]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['name' => 'This value is too long. It should have 255 characters or less.']);
        
        $id = $I->grabColumnFromDatabase(Category::TABLE_NAME, 'id', ['name' => 'Test category']);

        // Выбор категории по id
        $I->sendGET('/category/'.$id[0], ['authorization' => $I->getAdminToken()]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['name' => 'Test category']);
        
        $I->sendGET('/category/23', ['authorization' => $I->getAdminToken()]);
        $I->seeResponseCodeIs(404);
        $I->seeResponseContainsJson(['message' => 'Category not found']);
        
        // Редактирование категории
        $I->sendPATCH('/category/update/?authorization='.$I->getAdminToken(), ['id' => $id[0], 'name' => 'Update category']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['code' => 200, 'message' => 'OK']);
        $I->sendGET('/category/'.$id[0], ['authorization' => $I->getAdminToken()]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['name' => 'Update category']);
        
        // Редактирование категории без названия
        $I->sendPATCH('/category/update?authorization='.$I->getAdminToken(), ['id' => $id[0]]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['name' => 'This value should not be blank.']);
        
        // Редактирование категории через POST
        $I->sendPOST('/category/update/?authorization='.$I->getAdminToken(), ['id' => $id[0], 'name' => 'Update category POST']);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['code' => 400, 'message' => 'Bad Request', 'token' => $I->getAdminToken()]);
        $I->dontSeeInDatabase(Category::TABLE_NAME, ['name' => 'Update category POST']);
        
        // Редактирование категории без доступа
        $I->sendPATCH('/category/update/?authorization='.$I->getUserToken(), ['id' => $id[0], 'name' => 'Update category forbidden']);
        $I->seeResponseCodeIs(403);
        $I->seeResponseContainsJson(['code' => 403, 'message' => 'Forbidden', 'token' => $I->getUserToken()]);
        $I->dontSeeInDatabase(Category::TABLE_NAME, ['name' => 'Update category forbidden']);
        
        // Редактирование категории с коротким названием
        $I->sendPATCH('/category/update?authorization='.$I->getAdminToken(), ['id' => $id[0], 'name' => 'Te']);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['name' => 'This value is too short. It should have 3 characters or more.']);
        
        // Редактирование категории с длинным названием
        $I->sendPATCH('/category/update?authorization='.$I->getAdminToken(), ['id' => $id[0], 'name' => StringGenerator::randomAlnum(260)]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['name' => 'This value is too long. It should have 255 characters or less.']);
        
        // Удаление несуществующей категории
        $I->sendDELETE('/category/delete?authorization='.$I->getAdminToken(), ['id' => 206]);
        $I->seeResponseCodeIs(404);
        $I->seeResponseContainsJson(['message' => 'Category not found']);
        
        // Удаление категории через POST
        $I->sendPOST('/category/delete/?authorization='.$I->getAdminToken(), ['id' => $id[0]]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['code' => 400, 'message' => 'Bad Request', 'token' => $I->getAdminToken()]);
        $I->sendGET('/category/'.$id[0], ['authorization' => $I->getAdminToken()]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['name' => 'Update category']);
        
        // Удаление категории без доступа
        $I->sendDELETE('/category/delete/?authorization='.$I->getUserToken(), ['id' => $id[0]]);
        $I->seeResponseCodeIs(403);
        $I->seeResponseContainsJson(['code' => 403, 'message' => 'Forbidden', 'token' => $I->getUserToken()]);
        $I->sendGET('/category/'.$id[0], ['authorization' => $I->getAdminToken()]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['name' => 'Update category']);
        
        // Удаление категории
        $I->sendDELETE('/category/delete?authorization='.$I->getAdminToken(), ['id' => $id[0]]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['code' => 200, 'message' => 'OK']);
        $I->sendGET('/category/'.$id[0], ['authorization' => $I->getAdminToken()]);
        $I->seeResponseCodeIs(404);
        $I->seeResponseContainsJson(['message' => 'Category not found']);
    }
}
