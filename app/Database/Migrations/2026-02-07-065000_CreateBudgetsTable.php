<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBudgetsTable extends Migration
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
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'month' => [
                'type'       => 'INT',
                'constraint' => 2,
                'comment'    => 'Month (1-12)',
            ],
            'year' => [
                'type'       => 'INT',
                'constraint' => 4,
                'comment'    => 'Year (e.g., 2026)',
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
        $this->forge->addUniqueKey(['user_id', 'category', 'month', 'year'], 'unique_budget');
        $this->forge->createTable('budgets', true);

        $this->db->query('ALTER TABLE budgets ADD CONSTRAINT fk_budgets_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('budgets', true);
    }
}
