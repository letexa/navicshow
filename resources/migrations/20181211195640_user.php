<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;
use Sinergi\Token\StringGenerator;
use app\model\User as UserModel;

class User extends AbstractMigration
{
    public function up()
    {
        $table = $this->table(UserModel::TABLE_NAME);
        $table->addColumn('username', 'string', ['limit' => 20])
              ->addColumn('token', 'string', ['limit' => 70])
              ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addIndex('token', ['unique' => true, 'name' => 'idx_token'])
              ->create();
        
        $row = [
            'username' => 'admin',
            'token' => StringGenerator::randomAlnum(70)
        ];
        
        $table->insert($row)->saveData();
    }

    public function down()
    {
        $this->table(UserModel::TABLE_NAME)->drop()->save();
    }
}
