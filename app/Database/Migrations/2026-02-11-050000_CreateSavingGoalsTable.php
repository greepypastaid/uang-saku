<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSavingGoalsTable extends Migration
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
            'partner_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'ownership_type' => [
                'type'       => "ENUM('individual','couple')",
                'default'    => 'individual',
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'target_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'current_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
            ],
            'icon' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'priority' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'deadline' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'status' => [
                'type'    => "ENUM('active','completed','cancelled')",
                'default' => 'active',
            ],
            'completed_at' => [
                'type' => 'DATETIME',
                'null' => true,
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
        $this->forge->addKey('user_id');
        $this->forge->addUniqueKey(['user_id', 'name'], 'unique_user_goal');
        $this->forge->createTable('saving_goals', true);

        $this->db->query('ALTER TABLE saving_goals ADD CONSTRAINT fk_sg_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE saving_goals ADD CONSTRAINT fk_sg_partner FOREIGN KEY (partner_id) REFERENCES users(id) ON DELETE SET NULL');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE saving_goals DROP FOREIGN KEY fk_sg_user');
        $this->db->query('ALTER TABLE saving_goals DROP FOREIGN KEY fk_sg_partner');
        $this->forge->dropTable('saving_goals', true);
    }
}
