<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserBadgesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'badge_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'badge_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'badge_icon' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'earned_at' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['user_id', 'badge_code'], 'unique_user_badge');
        $this->forge->createTable('user_badges', true);

        $this->db->query('ALTER TABLE user_badges ADD CONSTRAINT fk_ub_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE user_badges DROP FOREIGN KEY fk_ub_user');
        $this->forge->dropTable('user_badges', true);
    }
}
