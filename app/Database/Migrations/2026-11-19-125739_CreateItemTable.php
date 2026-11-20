<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateItemTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'sku' => [
                'type' => 'VARCHAR',
                'constraint' => '60',
                'unique' => true,
            ],
            'item_name' => [
                'type' => 'VARCHAR',
                'constraint' => '60',
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => '60',
            ],
            'min_stock' => [
                'type' => 'INT',
                'constraint' => '11',
                'default' => 0,
            ],
            'current_stock' => [
                'type' => 'INT',
                'constraint' => '11',
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('items');
    }

    public function down()
    {
        $this->forge->dropTable('items');
    }
}
