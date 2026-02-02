<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        if (!$this->db->tableExists('transaksi')) {
            $this->forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'wallet_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
                'transfer_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
                'nama_transaksi' => ['type' => 'VARCHAR', 'constraint' => '255'],
                'harga' => ['type' => 'DECIMAL', 'constraint' => '15,2'],
                'kategori' => ['type' => 'VARCHAR', 'constraint' => '100'],
                'type' => ['type' => "ENUM('income','expense')", 'default' => 'expense'],
                'tanggal' => ['type' => 'DATE'],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('transaksi', true);

            $this->db->query('ALTER TABLE transaksi ADD CONSTRAINT fk_trx_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
            $this->db->query('ALTER TABLE transaksi ADD CONSTRAINT fk_trx_wallet FOREIGN KEY (wallet_id) REFERENCES wallets(id) ON DELETE CASCADE');
            $this->db->query('ALTER TABLE transaksi ADD CONSTRAINT fk_trx_transfer FOREIGN KEY (transfer_id) REFERENCES transfer(id) ON DELETE SET NULL');
        }
    }

    public function down()
    {
        $this->db->query('ALTER TABLE transaksi DROP FOREIGN KEY fk_trx_user');
        $this->db->query('ALTER TABLE transaksi DROP FOREIGN KEY fk_trx_wallet');
        $this->db->query('ALTER TABLE transaksi DROP FOREIGN KEY fk_trx_transfer');

        $this->forge->dropTable('transaksi', true);
    }
}
