<?php


use Phinx\Migration\AbstractMigration;
use app\model\Article as ArticleModel;
use app\model\Category as CategoryModel;

class Article extends AbstractMigration
{
    public function up()
    {
        $table = $this->table(ArticleModel::TABLE_NAME);
        $table->addColumn('title', 'string', ['limit' => 255])
              ->addColumn('text', 'text')
              ->addColumn('category_id', 'integer', ['limit' => 11])
              ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addForeignKey('category_id', CategoryModel::TABLE_NAME, 'id')
              ->create();
    }

    public function down()
    {
        $this->table(ArticleModel::TABLE_NAME)->drop()->save();
    }
}
