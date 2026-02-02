<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHutangPiutangTable extends Migration
{
    public function up()
    {
        if (!$this->db->tableExists('hutangpiutang')) {
            $this->forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'type' => ['type' => "ENUM('hutang','piutang')", 'null' => false],
                'person_name' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
                'amount' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'null' => false],
                'description' => ['type' => 'TEXT', 'null' => true],
                'due_date' => ['type' => 'DATE', 'null' => true],
                'status' => ['type' => "ENUM('unpaid','paid')", 'default' => 'unpaid'],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);

            $this->forge->addKey('id', true);
            $this->forge->addKey('user_id');
            $this->forge->createTable('hutangpiutang', true);

            $this->db->query('ALTER TABLE hutangpiutang ADD CONSTRAINT fk_hutangpiutang_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        }
    }

    public function down()
    {
        $this->db->query('ALTER TABLE hutangpiutang DROP FOREIGN KEY fk_hutangpiutang_users');
        $this->forge->dropTable('hutangpiutang', true);
    }
}
