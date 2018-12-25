<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;
use Sinergi\Token\StringGenerator;
use app\model\User as UserModel;
use app\model\Role as RoleModel;

class User extends AbstractMigration
{
    public function up()
    {
        $config = new \vakata\config\Config([ 'key' => 'value' ]);
        $config->fromFile('.env');
        
        $table = $this->table(UserModel::TABLE_NAME);
        $table->addColumn('username', 'string', ['limit' => 20])
              ->addColumn('token', 'string', ['limit' => 70])
              ->addColumn('role', 'integer', ['limit' => 2, 'signed' => false, 'default' => RoleModel::USER])
              ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addIndex('token', ['unique' => true, 'name' => 'idx_token'])
              ->create();
        
        $row = [
            ['username' => 'admin', 'token' => md5($config->get('ADMIN_TOKEN')), 'role' => RoleModel::ADMIN],
            ['username' => 'user', 'token' => md5($config->get('USER_TOKEN'))],
        ];
        
        $table->insert($row)->saveData();
    }

    public function down()
    {
        $this->table(UserModel::TABLE_NAME)->drop()->save();
    }
}
