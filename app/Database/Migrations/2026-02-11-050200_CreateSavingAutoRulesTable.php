<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSavingAutoRulesTable extends Migration
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
            'goal_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'allocation_type' => [
                'type' => "ENUM('percentage','fixed')",
            ],
            'allocation_value' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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
        $this->forge->addUniqueKey(['user_id', 'goal_id'], 'unique_user_goal_rule');
        $this->forge->createTable('saving_auto_rules', true);

        $this->db->query('ALTER TABLE saving_auto_rules ADD CONSTRAINT fk_sar_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE saving_auto_rules ADD CONSTRAINT fk_sar_goal FOREIGN KEY (goal_id) REFERENCES saving_goals(id) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE saving_auto_rules DROP FOREIGN KEY fk_sar_user');
        $this->db->query('ALTER TABLE saving_auto_rules DROP FOREIGN KEY fk_sar_goal');
        $this->forge->dropTable('saving_auto_rules', true);
    }
}
