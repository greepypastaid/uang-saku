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
            'created_at' => ['type' => 'DATETIME', 'null' => false, 'default' => date('Y-m-d H:i:s')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('from_wallet_id');
        $this->forge->addKey('to_wallet_id');
        $this->forge->createTable('transfer', true);

        // tambahkan FK (sesuaikan nama tabel wallet Anda; contoh: wallets)
        $this->db->query('ALTER TABLE transfer ADD CONSTRAINT fk_transfer_from_wallet FOREIGN KEY (from_wallet_id) REFERENCES wallets(id) ON DELETE RESTRICT ON UPDATE CASCADE');
        $this->db->query('ALTER TABLE transfer ADD CONSTRAINT fk_transfer_to_wallet   FOREIGN KEY (to_wallet_id)   REFERENCES wallets(id) ON DELETE RESTRICT ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('transfer', true);
    }
}
