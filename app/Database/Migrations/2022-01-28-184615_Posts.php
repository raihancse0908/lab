<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
{
    public function up()
    {            
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true
            ],
            'post_content' => [
                'type' => 'TEXT'
            ],
            'page_id' => [
                'type' => 'INT',
                'constraint' => 5
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 5
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('posts');
    }

    public function down()
    {
        //
    }
}
