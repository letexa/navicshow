<?php


use Phinx\Migration\AbstractMigration;
use app\model\Article as ArticleModel;

class Priview extends AbstractMigration
{
    public function up()
    {
        $table = $this->table(ArticleModel::TABLE_NAME);
        $table->addColumn('preview', 'text')->update();
    }

    public function down()
    {
        $table = $this->table(ArticleModel::TABLE_NAME);
        $table->removeColumn('preview')->update();
    }
}
