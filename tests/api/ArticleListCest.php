<?php 

use app\model\Category;
use Sinergi\Token\StringGenerator;

/**
 * Список статей
 * 
 */
class ArticleListCest
{
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
        // Добавить 20 новых статей
        for ($i = 20; $i > 0; $i--) {
            $I->sendPUT('/article/create?authorization='.$I->getAdminToken(), [
                'title' => 'Test article '.$i,
                'text' => StringGenerator::randomAlnum(260),
                'category_id' => $this->category_id
            ]);
        }
        
        // Limit 10
        $I->sendGET('/article/list?authorization='.$I->getUserToken(), ['limit' => 10]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        for ($i = 1; $i < 11; $i++) {
            $I->seeResponseContainsJson(['title' => 'Test article '.$i]);
        }
        for ($i = 11; $i < 21; $i++) {
            $I->dontSeeResponseContainsJson(['title' => 'Test article '.$i]);
        }
        
        // Limit 5
        $I->sendGET('/article/list?authorization='.$I->getUserToken(), ['limit' => 5]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        for ($i = 1; $i < 6; $i++) {
            $I->seeResponseContainsJson(['title' => 'Test article '.$i]);
        }
        for ($i = 6; $i < 21; $i++) {
            $I->dontSeeResponseContainsJson(['title' => 'Test article '.$i]);
        }
        
        // Offset 7
        $I->sendGET('/article/list?authorization='.$I->getUserToken(), ['limit' => 10, 'offset' => 7]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        for ($i = 1; $i < 8; $i++) {
            $I->dontSeeResponseContainsJson(['title' => 'Test article '.$i]);
        }
        for ($i = 8; $i < 18; $i++) {
            $I->seeResponseContainsJson(['title' => 'Test article '.$i]);
        }
        for ($i = 18; $i < 21; $i++) {
            $I->dontSeeResponseContainsJson(['title' => 'Test article '.$i]);
        }
    }
}
