<?php

declare(strict_types=1);

namespace Migration;

use Cycle\Migrations\Migration;

class OrmDefault5b01184a54c4923f2ca5767649da2739 extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $this->table('carts')
            ->addColumn('incremental_id', 'bigPrimary', ['nullable' => false, 'default' => null])
            ->addColumn('id', 'uuid', ['nullable' => false, 'default' => null])
            ->addColumn('created_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('created_by', 'json', ['nullable' => true, 'default' => null])
            ->addColumn('updated_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('updated_by', 'json', ['nullable' => true, 'default' => null])
            ->addColumn('deleted_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('deleted_by', 'json', ['nullable' => true, 'default' => null])
            ->setPrimaryKeys(['incremental_id'])
            ->create();
        $this->table('items')
            ->addColumn('incremental_id', 'bigPrimary', ['nullable' => false, 'default' => null])
            ->addColumn('cart_incrementalId', 'bigInteger', ['nullable' => false, 'default' => null])
            ->addIndex(['cart_incrementalId'], ['name' => 'items_index_cart_incrementalid_649ee7101f093', 'unique' => false])
            ->addForeignKey(['cart_incrementalId'], 'carts', ['incremental_id'], [
                'name' => 'items_foreign_cart_incrementalid_649ee7101f09c',
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
                'indexCreate' => true,
            ])
            ->setPrimaryKeys(['incremental_id'])
            ->create();
        $this->table('categories')
            ->addColumn('incremental_id', 'bigPrimary', ['nullable' => false, 'default' => null])
            ->addColumn('id', 'uuid', ['nullable' => false, 'default' => null])
            ->addColumn('name', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
            ->addColumn('gender', 'enum', ['nullable' => false, 'default' => null, 'values' => ['male', 'female', 'other']])
            ->addColumn('created_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('created_by', 'json', ['nullable' => true, 'default' => null])
            ->addColumn('updated_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('updated_by', 'json', ['nullable' => true, 'default' => null])
            ->addColumn('deleted_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('deleted_by', 'json', ['nullable' => true, 'default' => null])
            ->setPrimaryKeys(['incremental_id'])
            ->create();
        $this->table('clients')
            ->addColumn('incremental_id', 'bigPrimary', ['nullable' => false, 'default' => null])
            ->addColumn('id', 'uuid', ['nullable' => false, 'default' => null])
            ->addColumn('user_id', 'uuid', ['nullable' => true, 'default' => null])
            ->addColumn('email', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
            ->addColumn('username', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
            ->addColumn('company', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
            ->addColumn('first_name', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
            ->addColumn('last_name', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
            ->addColumn('middle_name', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
            ->addColumn('gender', 'enum', ['nullable' => false, 'default' => null, 'values' => ['male', 'female', 'other']])
            ->addColumn('birth_date', 'date', ['nullable' => true, 'default' => null])
            ->addColumn('created_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('created_by', 'json', ['nullable' => true, 'default' => null])
            ->addColumn('updated_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('updated_by', 'json', ['nullable' => true, 'default' => null])
            ->addColumn('deleted_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('deleted_by', 'json', ['nullable' => true, 'default' => null])
            ->setPrimaryKeys(['incremental_id'])
            ->create();
        $this->table('client_addresses')
            ->addColumn('incremental_id', 'bigPrimary', ['nullable' => false, 'default' => null])
            ->addColumn('id', 'uuid', ['nullable' => false, 'default' => null])
            ->addColumn('type', 'enum', ['nullable' => false, 'default' => null, 'values' => ['billing', 'shipping']])
            ->addColumn('is_default', 'boolean', ['nullable' => false, 'default' => false])
            ->addColumn('client_id', 'bigInteger', ['nullable' => false, 'default' => null])
            ->addColumn('created_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('created_by', 'json', ['nullable' => true, 'default' => null])
            ->addColumn('updated_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('updated_by', 'json', ['nullable' => true, 'default' => null])
            ->addColumn('deleted_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('deleted_by', 'json', ['nullable' => true, 'default' => null])
            ->addIndex(['client_id'], ['name' => 'client_addresses_index_client_id_649ee7101f286', 'unique' => false])
            ->addForeignKey(['client_id'], 'clients', ['incremental_id'], [
                'name' => 'client_addresses_foreign_client_id_649ee7101f28c',
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
                'indexCreate' => true,
            ])
            ->setPrimaryKeys(['incremental_id'])
            ->create();
        $this->table('countries')
            ->addColumn('id', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
            ->addColumn('name', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
            ->addColumn('emoji', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
            ->addColumn('iso_alpha2', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
            ->addColumn('iso_alpha3', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
            ->addColumn('iso_numeric', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
            ->setPrimaryKeys(['id'])
            ->create();
        $this->table('country_states')
            ->addColumn('id', 'primary', ['nullable' => false, 'default' => null])
            ->addColumn('code', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
            ->addColumn('name', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
            ->addColumn('country_id', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
            ->addIndex(['country_id'], ['name' => 'country_states_index_country_id_649ee7101f29e', 'unique' => false])
            ->addForeignKey(['country_id'], 'countries', ['id'], [
                'name' => 'country_states_foreign_country_id_649ee7101f2a2',
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
                'indexCreate' => true,
            ])
            ->setPrimaryKeys(['id'])
            ->create();
        $this->table('orders')
            ->addColumn('incremental_id', 'bigPrimary', ['nullable' => false, 'default' => null])
            ->addColumn('id', 'uuid', ['nullable' => false, 'default' => null])
            ->addColumn('created_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('created_by', 'json', ['nullable' => true, 'default' => null])
            ->addColumn('updated_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('updated_by', 'json', ['nullable' => true, 'default' => null])
            ->addColumn('deleted_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('deleted_by', 'json', ['nullable' => true, 'default' => null])
            ->setPrimaryKeys(['incremental_id'])
            ->create();
        $this->table('products')
            ->addColumn('incremental_id', 'bigPrimary', ['nullable' => false, 'default' => null])
            ->addColumn('id', 'uuid', ['nullable' => false, 'default' => null])
            ->addColumn('name', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
            ->addColumn('status', 'enum', [
                'nullable' => false,
                'default' => 'active',
                'values' => ['active', 'disabled', 'hidden'],
            ])
            ->addColumn('description', 'text', ['nullable' => false, 'default' => null])
            ->addColumn('category_id', 'bigInteger', ['nullable' => false, 'default' => null])
            ->addColumn('code_sku', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
            ->addColumn('code_ian', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
            ->addColumn('code_upc', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
            ->addColumn('seo_slug', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
            ->addColumn('seo_title', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
            ->addColumn('seo_description', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
            ->addColumn('created_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('created_by', 'json', ['nullable' => true, 'default' => null])
            ->addColumn('updated_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('updated_by', 'json', ['nullable' => true, 'default' => null])
            ->addColumn('deleted_at', 'datetime', ['nullable' => true, 'default' => null])
            ->addColumn('deleted_by', 'json', ['nullable' => true, 'default' => null])
            ->addIndex(['category_id'], ['name' => 'products_index_category_id_649ee7101f2b0', 'unique' => false])
            ->addForeignKey(['category_id'], 'categories', ['incremental_id'], [
                'name' => 'products_foreign_category_id_649ee7101f2b3',
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
                'indexCreate' => true,
            ])
            ->setPrimaryKeys(['incremental_id'])
            ->create();
    }

    public function down(): void
    {
        $this->table('products')->drop();
        $this->table('orders')->drop();
        $this->table('country_states')->drop();
        $this->table('countries')->drop();
        $this->table('client_addresses')->drop();
        $this->table('clients')->drop();
        $this->table('categories')->drop();
        $this->table('items')->drop();
        $this->table('carts')->drop();
    }
}
