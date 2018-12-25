<?php


use Phinx\Migration\AbstractMigration;
use app\model\Category as CategoryModel;

class Category extends AbstractMigration
{
    public function up()
    {
        $table = $this->table(CategoryModel::TABLE_NAME);
        $table->addColumn('name', 'string', ['limit' => 255])
              ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->create();
    }

    public function down()
    {
        $this->table(CategoryModel::TABLE_NAME)->drop()->save();
    }
}
