<?php

declare(strict_types=1);

namespace Migration;

use Cycle\Migrations\Migration;

class OrmDefault9296507f0aee2fd6fb380d0901b971a3 extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $this->table('users')
        ->addColumn('incremental_id', 'bigInteger', ['nullable' => false, 'default' => null])
        ->addColumn('email', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
        ->addColumn('company', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
        ->addColumn('name', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
        ->setPrimaryKeys(['incremental_id'])
        ->create();
        $this->table('roles')
        ->addColumn('id', 'primary', ['nullable' => false, 'default' => null])
        ->addColumn('name', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
        ->addColumn('user_incrementalId', 'bigInteger', ['nullable' => false, 'default' => null])
        ->addIndex(['user_incrementalId'], ['name' => 'roles_index_user_incrementalid_646522feb8e5f', 'unique' => false])
        ->addForeignKey(['user_incrementalId'], 'users', ['incremental_id'], [
            'name' => 'roles_foreign_user_incrementalid_646522feb8e6c',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
            'indexCreate' => true,
        ])
        ->setPrimaryKeys(['id'])
        ->create();
    }

    public function down(): void
    {
        $this->table('roles')->drop();
        $this->table('users')->drop();
    }
}
