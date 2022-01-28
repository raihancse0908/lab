<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pages extends Migration
{
    public function up()
    {        
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true
            ],
            'page_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 5
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pages');

    }

    public function down()
    {
        //
    }
}
