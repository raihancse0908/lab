<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Followers extends Migration
{
    public function up()
    {        
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5
            ],
            'page_id' => [
                'type' => 'INT',
                'constraint' => 5
            ],
            'followed_by' => [
                'type' => 'INT',
                'constraint' => 5
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('followers');
    }

    public function down()
    {
        //
    }
}
