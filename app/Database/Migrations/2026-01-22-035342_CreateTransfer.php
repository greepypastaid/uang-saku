<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransfer extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'from_wallet_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'to_wallet_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'amount' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'note' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('transfer', true);

        $this->db->query('ALTER TABLE transfer ADD CONSTRAINT fk_tf_from FOREIGN KEY (from_wallet_id) REFERENCES wallets(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE transfer ADD CONSTRAINT fk_tf_to   FOREIGN KEY (to_wallet_id)   REFERENCES wallets(id) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('transfer', true);
    }
}
