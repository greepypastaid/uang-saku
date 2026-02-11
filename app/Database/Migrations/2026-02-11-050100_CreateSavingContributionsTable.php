<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSavingContributionsTable extends Migration
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
            'goal_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'wallet_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'source' => [
                'type'    => "ENUM('manual','auto_allocation')",
                'default' => 'manual',
            ],
            'note' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('goal_id');
        $this->forge->addKey('user_id');
        $this->forge->createTable('saving_contributions', true);

        $this->db->query('ALTER TABLE saving_contributions ADD CONSTRAINT fk_sc_goal FOREIGN KEY (goal_id) REFERENCES saving_goals(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE saving_contributions ADD CONSTRAINT fk_sc_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE saving_contributions ADD CONSTRAINT fk_sc_wallet FOREIGN KEY (wallet_id) REFERENCES wallets(id) ON DELETE SET NULL');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE saving_contributions DROP FOREIGN KEY fk_sc_goal');
        $this->db->query('ALTER TABLE saving_contributions DROP FOREIGN KEY fk_sc_user');
        $this->db->query('ALTER TABLE saving_contributions DROP FOREIGN KEY fk_sc_wallet');
        $this->forge->dropTable('saving_contributions', true);
    }
}
