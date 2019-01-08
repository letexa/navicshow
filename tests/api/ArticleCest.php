<?php

use app\model\Category;
use app\model\Article;
use Sinergi\Token\StringGenerator;

/**
 * CRUD статьи
 * 
 */
class ArticleCest {
    
    private $category_id;
    
    public function _before(ApiTester $I)
    {
        // Добавить категорию
        $I->sendPUT('/category/create?authorization='.$I->getAdminToken(), ['name' => 'Test category']);
        $category_id = $I->grabColumnFromDatabase(Category::TABLE_NAME, 'id', ['name' => 'Test category']);
        $this->category_id = $category_id[0];
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
        
        // Добавление статьи
        $I->sendPUT('/article/create?authorization='.$I->getAdminToken(), [
            'title' => 'Test article',
            'text' => StringGenerator::randomAlnum(260),
            'category_id' => $this->category_id
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['code' => 200, 'message' => 'OK']);
        
        // Добавление статьи через POST
        $I->sendPOST('/article/create?authorization='.$I->getAdminToken(), [
            'title' => 'Test article whith POST',
            'text' => StringGenerator::randomAlnum(260),
            'category_id' => $this->category_id
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['code' => 400, 'message' => 'Bad Request', 'token' => $I->getAdminToken()]);
        
        // Добавление статьи без доступа
        $I->sendPUT('/article/create?authorization='.$I->getUserToken(), [
            'title' => 'Test article from user',
            'text' => StringGenerator::randomAlnum(260),
            'category_id' => $this->category_id
        ]);
        $I->seeResponseCodeIs(403);
        $I->seeResponseContainsJson(['code' => 403, 'message' => 'Forbidden', 'token' => $I->getUserToken()]);
        
        // Добавление статьи без названия
        $I->sendPUT('/article/create?authorization='.$I->getAdminToken(), [
            'text' => StringGenerator::randomAlnum(260),
            'category_id' => $this->category_id
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['title' => 'This value should not be blank.']);
        
        // Добавление статьи с коротким названия
        $I->sendPUT('/article/create?authorization='.$I->getAdminToken(), [
            'title' => 'Te',
            'text' => StringGenerator::randomAlnum(260),
            'category_id' => $this->category_id
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['title' => 'This value is too short. It should have 3 characters or more.']);
        
        // Добавление статьи с длинным названия
        $I->sendPUT('/article/create?authorization='.$I->getAdminToken(), [
            'title' => StringGenerator::randomAlnum(260),
            'text' => StringGenerator::randomAlnum(260),
            'category_id' => $this->category_id
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['title' => 'This value is too long. It should have 255 characters or less.']);
        
        // Добавление статьи без текста
        $I->sendPUT('/article/create?authorization='.$I->getAdminToken(), [
            'title' => StringGenerator::randomAlnum(50),
            'category_id' => $this->category_id
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['text' => 'This value should not be blank.']);
        
        // Добавление статьи с коротким текстом
        $I->sendPUT('/article/create?authorization='.$I->getAdminToken(), [
            'title' => StringGenerator::randomAlnum(50),
            'text' => StringGenerator::randomAlnum(50),
            'category_id' => $this->category_id
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['text' => 'This value is too short. It should have 100 characters or more.']);
        
        // Добавление статьи с длинным текстом
        $I->sendPUT('/article/create?authorization='.$I->getAdminToken(), [
            'title' => StringGenerator::randomAlnum(50),
            'text' => StringGenerator::randomAlnum(10001),
            'category_id' => $this->category_id
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['text' => 'This value is too long. It should have 10000 characters or less.']);
        
        // Добавление статьи без категории
        $I->sendPUT('/article/create?authorization='.$I->getAdminToken(), [
            'title' => StringGenerator::randomAlnum(50),
            'text' => StringGenerator::randomAlnum(1000)
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['category_id' => 'This value should not be blank.']);
        
        // Добавление статьи с несуществующей категорией
        $I->sendPUT('/article/create?authorization='.$I->getAdminToken(), [
            'title' => StringGenerator::randomAlnum(50),
            'text' => StringGenerator::randomAlnum(1000),
            'category_id' => 100
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['category_id' => 'Category does not exist.']);
        
        // Проверка добавленных статей
        $I->seeNumRecords(1, Article::TABLE_NAME);
        $I->seeInDatabase(Article::TABLE_NAME, ['title' => 'Test article']);
        
        $id = $I->grabColumnFromDatabase(Article::TABLE_NAME, 'id', ['title' => 'Test article']);
        $id = $id[0];
        
        // Выбор статьи по id
        $I->sendGET('/article/'.$id, ['authorization' => $I->getAdminToken()]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['title' => 'Test article']);
        
        $I->sendGET('/article/23', ['authorization' => $I->getAdminToken()]);
        $I->seeResponseCodeIs(404);
        $I->seeResponseContainsJson(['message' => 'Article not found']);
        
        // Редактирование статьи
        $I->sendPATCH('/article/update/?authorization='.$I->getAdminToken(), [
            'id' => $id, 
            'title' => 'Update article title',
            'text' => 'Update article text'
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['code' => 200, 'message' => 'OK']);
        
        // Редактирование статьи через POST
        $I->sendPOST('/article/update/?authorization='.$I->getAdminToken(), [
            'id' => $id, 
            'title' => 'Update article title POST',
            'text' => 'Update article text POST'
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['code' => 400, 'message' => 'Bad Request', 'token' => $I->getAdminToken()]);
        
        // Редактирование статьи без доступа
        $I->sendPATCH('/article/update/?authorization='.$I->getUserToken(), [
            'id' => $id, 
            'title' => 'Update article title forbidden',
            'text' => 'Update article text forbidden'
        ]);
        $I->seeResponseCodeIs(403);
        $I->seeResponseContainsJson(['code' => 403, 'message' => 'Forbidden', 'token' => $I->getUserToken()]);
        $I->dontSeeInDatabase(Category::TABLE_NAME, ['name' => 'Update category forbidden']);
        
        // Проверка статьи после обновлений
        $I->sendGET('/category/'.$id, ['authorization' => $I->getAdminToken()]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['title' => 'Update article title', 'text' => 'Update article text']);
        
    }
}